<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $packages = $query->latest()->get();
        return view('packages.index', compact('packages'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('packages.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        $data = $request->only(['name', 'price', 'description']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('images/packages');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['image_url'] = 'images/packages/' . $filename;
        }

        $package = Package::create($data);

        // Attach products to package
        $syncData = [];
        foreach ($request->products as $item) {
            $syncData[$item['id']] = ['qty' => $item['qty']];
        }
        $package->products()->sync($syncData);

        return redirect()->route('packages.index')->with('success', 'Menu Paket berhasil ditambahkan! 🎁');
    }

    public function show(Package $package)
    {
        $package->load('products');
        return view('packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('packages.edit', compact('package', 'products'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        $data = $request->only(['name', 'price', 'description']);

        if ($request->hasFile('image')) {
            if ($package->image_url && File::exists(public_path($package->image_url))) {
                File::delete(public_path($package->image_url));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('images/packages');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['image_url'] = 'images/packages/' . $filename;
        }

        $package->update($data);

        // Sync products
        $syncData = [];
        foreach ($request->products as $item) {
            $syncData[$item['id']] = ['qty' => $item['qty']];
        }
        $package->products()->sync($syncData);

        return redirect()->route('packages.index')->with('success', 'Menu Paket berhasil diperbarui! 🎁');
    }

    public function destroy(Package $package)
    {
        if ($package->image_url && File::exists(public_path($package->image_url))) {
            File::delete(public_path($package->image_url));
        }

        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Menu Paket berhasil dihapus.');
    }
}
