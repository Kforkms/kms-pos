<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                {{-- Breadcrumbs --}}
                <nav class="flex items-center text-xs text-gray-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-pink-600 transition-colors">Home</a>
                    <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-pink-600 font-semibold">Manajemen Produk</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    Data Produk
                </h2>
            </div>
            <div class="flex items-center gap-3">
                {{-- Search --}}
                <form method="GET" action="{{ route('products.index') }}" class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                           class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:border-pink-400 focus:ring-pink-300 w-56 transition-all">
                </form>
                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2 px-5 rounded-xl shadow-md shadow-pink-200 transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                    Tambah Produk
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Product Table --}}
    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/80 border-b border-gray-100">
                    <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                    <th class="py-3.5 px-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $i => $product)
                    <tr class="hover:bg-pink-50/40 transition-colors duration-200">
                        <td class="py-3.5 px-5 text-sm text-gray-400 font-medium">{{ $i + 1 }}</td>
                        <td class="py-3.5 px-5">
                            <div class="flex items-center gap-3">
                                {{-- Thumbnail --}}
                                <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 border border-gray-100">
                                    @if($product->image_url)
                                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';">
                                        <div class="w-full h-full bg-pink-100 items-center justify-center text-pink-600 font-bold text-xs hidden">
                                            {{ strtoupper(substr($product->name, 0, 2)) }}
                                        </div>
                                    @else
                                        <div class="w-full h-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold text-xs">
                                            {{ strtoupper(substr($product->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                {{-- Name as clickable link --}}
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="text-sm font-semibold text-pink-600 hover:text-pink-800 hover:underline transition-all">
                                    {{ $product->name }}
                                </a>
                            </div>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold
                                {{ $product->category === 'makanan' ? 'bg-orange-50 text-orange-600 border border-orange-200' : ($product->category === 'minuman' ? 'bg-blue-50 text-blue-600 border border-blue-200' : 'bg-purple-50 text-purple-600 border border-purple-200') }}">
                                @if($product->category === 'makanan') 🍛 @elseif($product->category === 'minuman') 🥤 @else 🍿 @endif
                                {{ ucfirst($product->category) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-sm font-semibold text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="py-3.5 px-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                {{ $product->stock > 10 ? 'bg-green-50 text-green-700 border border-green-200' : ($product->stock > 0 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-red-50 text-red-700 border border-red-200') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="inline-flex items-center gap-1 text-xs font-semibold text-sky-600 hover:text-sky-800 bg-sky-50 hover:bg-sky-100 px-3 py-1.5 rounded-lg transition-all duration-200"
                                   title="Lihat Detail">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="inline-flex items-center gap-1 text-xs font-semibold text-pink-600 hover:text-pink-800 bg-pink-50 hover:bg-pink-100 px-3 py-1.5 rounded-lg transition-all duration-200"
                                   title="Edit Produk">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 text-xs font-semibold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-all duration-200"
                                            title="Hapus Produk">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                <p class="text-sm text-gray-400 font-medium">Belum ada produk terdaftar.</p>
                                <a href="{{ route('products.create') }}" class="mt-2 text-sm text-pink-600 hover:text-pink-700 font-semibold">+ Tambah produk pertama</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
