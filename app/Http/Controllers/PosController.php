<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\Shift;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        // Check for active shift
        $activeShift = Shift::where('user_id', auth()->id())
            ->where('status', 'open')
            ->first();

        if (!$activeShift) {
            return redirect()->route('shift.index');
        }

        $products = Product::where('stock', '>', 0)->get();
        $qrisSetting = \App\Models\Setting::where('key', 'qris_image_path')->first();
        $qrisImage = $qrisSetting ? $qrisSetting->value : null;

        return view('pos.index', compact('products', 'qrisImage', 'activeShift'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,qris',
            'paid_amount' => 'required|integer|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
            'customer_name' => 'nullable|string|max:255',
            'order_type' => 'required|in:dine_in,takeaway,online',
            'discount' => 'nullable|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Check active shift
            $activeShift = Shift::where('user_id', auth()->id())
                ->where('status', 'open')
                ->first();

            if (!$activeShift) {
                throw new \Exception('Tidak ada shift aktif. Buka shift terlebih dahulu.');
            }

            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $discount = (int) ($request->discount ?? 0);
            if ($discount > $subtotal) {
                $discount = $subtotal;
            }
            $totalAmount = $subtotal - $discount;

            if ($request->payment_method === 'cash' && $request->paid_amount < $totalAmount) {
                throw new \Exception('Nominal bayar kurang dari total');
            }

            $changeAmount = $request->payment_method === 'cash' ? $request->paid_amount - $totalAmount : 0;

            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'user_id' => auth()->id(),
                'shift_id' => $activeShift->id,
                'customer_name' => $request->customer_name,
                'order_type' => $request->order_type ?? 'dine_in',
                'total_amount' => $totalAmount,
                'discount' => $discount,
                'payment_method' => $request->payment_method,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $changeAmount,
            ]);

            foreach ($request->items as $item) {
                $itemSubtotal = $item['price'] * $item['quantity'];

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $itemSubtotal,
                ]);

                $product = Product::lockForUpdate()->find($item['product_id']);

                // Check if product has ingredient recipe
                $ingredientRecipe = $product->ingredients;

                if ($ingredientRecipe->count() > 0) {
                    // Deduct ingredient stock based on recipe
                    foreach ($ingredientRecipe as $ingredient) {
                        $totalNeeded = $ingredient->pivot->qty_required * $item['quantity'];
                        $ingredientModel = Ingredient::lockForUpdate()->find($ingredient->id);

                        if ($ingredientModel->stock < $totalNeeded) {
                            throw new \Exception(
                                'Stok bahan "' . $ingredientModel->name . '" tidak cukup. ' .
                                'Butuh: ' . $totalNeeded . ' ' . $ingredientModel->unit .
                                ', Sisa: ' . $ingredientModel->stock . ' ' . $ingredientModel->unit
                            );
                        }

                        $ingredientModel->decrement('stock', $totalNeeded);
                    }
                } else {
                    // No recipe, deduct product stock directly
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception('Stok produk ' . $product->name . ' tidak mencukupi');
                    }
                    $product->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Transaksi berhasil disimpan! 🎉');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
