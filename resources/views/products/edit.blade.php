<x-app-layout>
    <x-slot name="header">
        <div>
            {{-- Breadcrumbs --}}
            <nav class="flex items-center text-xs text-gray-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-pink-600 transition-colors">Home</a>
                <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('products.index') }}" class="hover:text-pink-600 transition-colors">Manajemen Produk</a>
                <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-pink-600 font-semibold">Edit Produk</span>
            </nav>
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                Edit Produk
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="p-6 md:p-8">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Produk --}}
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                               class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-800 focus:border-pink-400 focus:ring-pink-300 transition-all"
                               placeholder="Contoh: Nasi Goreng Spesial" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-5">
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori</label>
                        <select name="category" id="category"
                                class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-800 focus:border-pink-400 focus:ring-pink-300 transition-all" required>
                            <option value="makanan" {{ old('category', $product->category) == 'makanan' ? 'selected' : '' }}>🍛 Makanan</option>
                            <option value="minuman" {{ old('category', $product->category) == 'minuman' ? 'selected' : '' }}>🥤 Minuman</option>
                            <option value="snack" {{ old('category', $product->category) == 'snack' ? 'selected' : '' }}>🍿 Snack</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga & Stok (Grid) --}}
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-1.5">Harga (Rp)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                                   class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-800 focus:border-pink-400 focus:ring-pink-300 transition-all"
                                   placeholder="15000" min="0" required>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1.5">Stok</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                                   class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-800 focus:border-pink-400 focus:ring-pink-300 transition-all"
                                   placeholder="100" min="0" required>
                            @error('stock')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Upload Gambar --}}
                    <div class="mb-7" x-data="{ preview: '{{ $product->image_url ? asset($product->image_url) : '' }}' }">
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-1.5">Gambar Produk</label>
                        <div class="flex items-center gap-4">
                            {{-- Preview --}}
                            <div class="w-20 h-20 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden bg-gray-50 flex-shrink-0">
                                <template x-if="preview">
                                    <img :src="preview" class="w-full h-full object-cover rounded-lg">
                                </template>
                                <template x-if="!preview">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                                    </svg>
                                </template>
                            </div>
                            {{-- Input --}}
                            <div class="flex-1">
                                <input type="file" name="image" id="image" accept="image/jpeg,image/jpg,image/png"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-600 hover:file:bg-pink-100 transition-all cursor-pointer"
                                       @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } else { preview = null; }">
                                <p class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG. Maks: 2MB. Kosongkan jika tidak ingin mengganti.</p>
                                @if($product->image_url)
                                    <p class="text-xs text-green-600 mt-0.5 font-medium">✓ Gambar saat ini: {{ basename($product->image_url) }}</p>
                                @endif
                            </div>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('products.index') }}"
                           class="px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all duration-200">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-md shadow-pink-200 transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Update Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
