<x-app-layout>
    <x-slot name="header">
        <div>
            {{-- Breadcrumbs --}}
            <nav class="flex items-center text-xs text-gray-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-pink-600 transition-colors">Home</a>
                <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('products.index') }}" class="hover:text-pink-600 transition-colors">Manajemen Produk</a>
                <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-pink-600 font-semibold">Detail Produk</span>
            </nav>
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                Detail Produk
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
            {{-- Hero Image / Fallback --}}
            <div class="relative h-56 bg-gradient-to-br from-pink-50 to-pink-100 overflow-hidden">
                @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="w-full h-full items-center justify-center hidden absolute inset-0 bg-gradient-to-br from-pink-50 to-pink-100">
                        @if($product->category === 'makanan')
                            <span class="text-7xl">🍛</span>
                        @elseif($product->category === 'minuman')
                            <span class="text-7xl">🥤</span>
                        @else
                            <span class="text-7xl">🍿</span>
                        @endif
                    </div>
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        @if($product->category === 'makanan')
                            <span class="text-7xl">🍛</span>
                        @elseif($product->category === 'minuman')
                            <span class="text-7xl">🥤</span>
                        @else
                            <span class="text-7xl">🍿</span>
                        @endif
                    </div>
                @endif

                {{-- Category Badge --}}
                <div class="absolute top-4 right-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold shadow-md
                        {{ $product->category === 'makanan' ? 'bg-orange-500 text-white' : ($product->category === 'minuman' ? 'bg-blue-500 text-white' : 'bg-purple-500 text-white') }}">
                        @if($product->category === 'makanan') 🍛 @elseif($product->category === 'minuman') 🥤 @else 🍿 @endif
                        {{ ucfirst($product->category) }}
                    </span>
                </div>
            </div>

            {{-- Product Info --}}
            <div class="p-6 md:p-8">
                {{-- Name & Price --}}
                <div class="mb-6">
                    <h3 class="text-2xl font-extrabold text-gray-800 mb-1">{{ $product->name }}</h3>
                    <p class="text-3xl font-extrabold text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                {{-- Detail Cards --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                    {{-- Kategori --}}
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kategori</p>
                        <p class="text-sm font-bold text-gray-800">{{ ucfirst($product->category) }}</p>
                    </div>

                    {{-- Stok --}}
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Stok</p>
                        <p class="text-sm font-bold {{ $product->stock > 10 ? 'text-green-600' : ($product->stock > 0 ? 'text-amber-600' : 'text-red-600') }}">
                            {{ number_format($product->stock) }} unit
                        </p>
                    </div>

                    {{-- Dibuat --}}
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Dibuat</p>
                        <p class="text-sm font-bold text-gray-800">{{ $product->created_at->format('d M Y') }}</p>
                    </div>

                    {{-- Diperbarui --}}
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Diperbarui</p>
                        <p class="text-sm font-bold text-gray-800">{{ $product->updated_at->format('d M Y') }}</p>
                    </div>
                </div>

                {{-- Ingredient Recipe (if any) --}}
                @if($product->ingredients->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            Resep Bahan Baku
                        </h4>
                        <div class="bg-pink-50/50 border border-pink-100 rounded-xl p-4">
                            <div class="space-y-2">
                                @foreach($product->ingredients as $ingredient)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-700 font-medium">{{ $ingredient->name }}</span>
                                        <span class="text-pink-600 font-bold">{{ $ingredient->pivot->qty_required }} {{ $ingredient->unit }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali
                    </a>
                    <a href="{{ route('products.edit', $product->id) }}"
                       class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-md shadow-pink-200 transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
