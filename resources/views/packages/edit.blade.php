<x-app-layout>
    <x-slot name="header">
        <div>
            {{-- Breadcrumbs --}}
            <nav class="flex items-center text-xs text-gray-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-pink-600 transition-colors">Home</a>
                <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('packages.index') }}" class="hover:text-pink-600 transition-colors">Menu Paket</a>
                <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-pink-600 font-semibold">Edit Paket</span>
            </nav>
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                Edit Menu Paket 🎁
            </h2>
        </div>
    </x-slot>

    <div class="max-w-5xl">
        <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex flex-col lg:flex-row gap-6">
                {{-- AREA KIRI: Info Paket --}}
                <div class="w-full lg:w-1/3 space-y-6">
                    <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Paket</h3>

                        {{-- Nama --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Paket</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $package->name) }}"
                                   class="w-full border border-gray-200 rounded-xl py-2 px-3 text-sm text-gray-800 focus:border-pink-400 focus:ring-pink-300 transition-all"
                                   placeholder="Contoh: Paket Combo A" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Paket (Rp)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $package->price) }}"
                                   class="w-full border border-gray-200 rounded-xl py-2 px-3 text-sm text-gray-800 focus:border-pink-400 focus:ring-pink-300 transition-all"
                                   placeholder="35000" min="0" required>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full border border-gray-200 rounded-xl py-2 px-3 text-sm text-gray-800 focus:border-pink-400 focus:ring-pink-300 transition-all"
                                      placeholder="Isi paket dan penjelasan...">{{ old('description', $package->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Upload Gambar --}}
                        <div class="mb-4" x-data="{ preview: '{{ $package->image_url ? asset($package->image_url) : '' }}' }">
                            <label for="image" class="block text-sm font-semibold text-gray-700 mb-1.5">Gambar Paket</label>
                            <div class="flex items-center gap-3">
                                <div class="w-16 h-16 rounded-xl border border-gray-200 flex items-center justify-center overflow-hidden bg-gray-50 flex-shrink-0">
                                    <template x-if="preview">
                                        <img :src="preview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!preview">
                                        <span class="text-2xl">🎁</span>
                                    </template>
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="image" id="image" accept="image/jpeg,image/jpg,image/png"
                                           class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-pink-600 hover:file:bg-pink-100 transition-all cursor-pointer"
                                           @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } else { preview = null; }">
                                    <p class="text-[10px] text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6">
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-6 rounded-xl shadow-md shadow-pink-200 transition-all duration-300 hover:shadow-lg hover:scale-[1.02] mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Update Menu Paket
                        </button>
                        <a href="{{ route('packages.index') }}"
                           class="w-full inline-flex items-center justify-center py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all duration-200 border border-gray-200">
                            Batal
                        </a>
                    </div>
                </div>

                {{-- AREA KANAN: Pilihan Produk --}}
                <div class="w-full lg:w-2/3" x-data="{ search: '', category: 'all' }">
                    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden flex flex-col h-[calc(100vh-180px)] min-h-[500px]">
                        <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <h3 class="text-lg font-bold text-gray-800">Edit Isi Paket</h3>
                            @error('products')
                                <span class="bg-red-50 text-red-600 text-xs font-bold px-3 py-1 rounded-full border border-red-200">
                                    Minimal pilih 1 produk!
                                </span>
                            @enderror
                        </div>

                        {{-- Search & Filter Bar --}}
                        <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row gap-3">
                            <div class="relative flex-1">
                                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" x-model="search" placeholder="Cari nama produk..."
                                       class="pl-9 pr-3 py-2 w-full text-sm border border-gray-200 rounded-xl focus:border-pink-400 focus:ring-pink-300 transition-all">
                            </div>
                            <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
                                <button type="button" @click="category = 'all'"
                                        class="px-4 py-2 text-xs font-bold rounded-xl transition-all whitespace-nowrap"
                                        :class="category === 'all' ? 'bg-pink-600 text-white shadow-md shadow-pink-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                                    Semua
                                </button>
                                <button type="button" @click="category = 'makanan'"
                                        class="px-4 py-2 text-xs font-bold rounded-xl transition-all whitespace-nowrap"
                                        :class="category === 'makanan' ? 'bg-orange-500 text-white shadow-md shadow-orange-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                                    🍛 Makanan
                                </button>
                                <button type="button" @click="category = 'minuman'"
                                        class="px-4 py-2 text-xs font-bold rounded-xl transition-all whitespace-nowrap"
                                        :class="category === 'minuman' ? 'bg-blue-500 text-white shadow-md shadow-blue-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                                    🥤 Minuman
                                </button>
                                <button type="button" @click="category = 'snack'"
                                        class="px-4 py-2 text-xs font-bold rounded-xl transition-all whitespace-nowrap"
                                        :class="category === 'snack' ? 'bg-purple-500 text-white shadow-md shadow-purple-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                                    🍿 Snack
                                </button>
                            </div>
                        </div>

                        @php
                            // Buat array lookup [product_id => qty] dari database
                            $packageProducts = $package->products->pluck('pivot.qty', 'id')->toArray();
                        @endphp

                        <div class="p-6 overflow-y-auto flex-1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($products as $product)
                                    @php
                                        // Tentukan apakah produk ini selected berdasarkan old input atau database
                                        $isSelected = old('products') ? isset(old('products')[$product->id]) : array_key_exists($product->id, $packageProducts);
                                        $qtyValue = old('products.' . $product->id . '.qty', $isSelected && isset($packageProducts[$product->id]) ? $packageProducts[$product->id] : 1);
                                    @endphp

                                    <div x-data="{ selected: {{ $isSelected ? 'true' : 'false' }} }"
                                         x-show="(category === 'all' || category === '{{ $product->category }}') && searchMatch('{{ addslashes(strtolower($product->name)) }}', search.toLowerCase())"
                                         x-transition
                                         class="border-2 rounded-xl p-3 transition-all cursor-pointer relative"
                                         :class="selected ? 'border-pink-500 bg-pink-50/30 shadow-md' : 'border-gray-100 hover:border-pink-200 bg-white'"
                                         @click="if($event.target.tagName !== 'INPUT') selected = !selected">

                                        <div class="flex items-start gap-3">
                                            {{-- Checkbox --}}
                                            <div class="pt-1">
                                                <input type="checkbox" name="products[{{$product->id}}][id]" value="{{$product->id}}"
                                                       x-model="selected"
                                                       class="w-5 h-5 text-pink-600 rounded border-gray-300 focus:ring-pink-500 cursor-pointer">
                                            </div>

                                            {{-- Info --}}
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-lg">
                                                        @if($product->category === 'makanan') 🍛 @elseif($product->category === 'minuman') 🥤 @else 🍿 @endif
                                                    </span>
                                                    <p class="font-bold text-sm text-gray-800 leading-tight">{{ $product->name }}</p>
                                                </div>
                                                <p class="text-xs text-pink-600 font-semibold mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                                                {{-- Qty Input (Hanya tampil jika selected) --}}
                                                <div x-show="selected" x-transition.opacity>
                                                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 block">Quantity dalam paket:</label>
                                                    <div class="flex items-center gap-2">
                                                        <input type="number" name="products[{{$product->id}}][qty]"
                                                               value="{{ $qtyValue }}"
                                                               min="1" max="10"
                                                               x-bind:disabled="!selected"
                                                               class="w-20 py-1 px-2 border border-pink-200 rounded-lg text-sm text-center font-bold focus:border-pink-500 focus:ring-pink-300">
                                                        <span class="text-xs text-gray-500">Porsi / Cup</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($products->isEmpty())
                                <div class="text-center py-12">
                                    <p class="text-gray-400 font-medium">Tidak ada produk tersedia.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function searchMatch(name, term) {
            if (!term) return true;
            return name.includes(term);
        }
    </script>
</x-app-layout>
