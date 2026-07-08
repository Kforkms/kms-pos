<x-app-layout>
    <x-slot name="header">
        <div>
            {{-- Breadcrumbs --}}
            <nav class="flex items-center text-xs text-gray-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-pink-600 transition-colors">Home</a>
                <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-pink-600 font-semibold">Kasir (POS)</span>
            </nav>
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    Point of Sale ✨
                </h2>
                @if(isset($activeShift))
                    <div class="flex items-center gap-2 bg-green-50 border border-green-200 px-3 py-1.5 rounded-full">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-xs font-bold text-green-700">Shift Aktif • Modal: Rp {{ number_format($activeShift->starting_cash, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6" x-data="cartData()">

        {{-- ============================== --}}
        {{-- AREA KIRI: Grid Produk --}}
        {{-- ============================== --}}
        <div class="w-full lg:w-[60%] xl:w-2/3">
            {{-- Search & Category Filter --}}
            <div class="mb-4 space-y-3">
                {{-- Search --}}
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="searchQuery" placeholder="Cari menu produk..."
                           class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:border-pink-400 focus:ring-pink-300 bg-white transition-all">
                </div>

                {{-- Category Tabs --}}
                <div class="flex gap-2 flex-wrap">
                    <button type="button" @click="activeCategory = 'semua'"
                            :class="activeCategory === 'semua' ? 'bg-pink-500 text-white shadow-md shadow-pink-200' : 'bg-white text-gray-500 border border-gray-200 hover:border-pink-300 hover:text-pink-600'"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200">
                        🍽️ Semua
                    </button>
                    <button type="button" @click="activeCategory = 'makanan'"
                            :class="activeCategory === 'makanan' ? 'bg-pink-500 text-white shadow-md shadow-pink-200' : 'bg-white text-gray-500 border border-gray-200 hover:border-pink-300 hover:text-pink-600'"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200">
                        🍛 Makanan
                    </button>
                    <button type="button" @click="activeCategory = 'minuman'"
                            :class="activeCategory === 'minuman' ? 'bg-pink-500 text-white shadow-md shadow-pink-200' : 'bg-white text-gray-500 border border-gray-200 hover:border-pink-300 hover:text-pink-600'"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200">
                        🥤 Minuman
                    </button>
                    <button type="button" @click="activeCategory = 'snack'"
                            :class="activeCategory === 'snack' ? 'bg-pink-500 text-white shadow-md shadow-pink-200' : 'bg-white text-gray-500 border border-gray-200 hover:border-pink-300 hover:text-pink-600'"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200">
                        🍿 Snack
                    </button>
                </div>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3">
                @foreach($products as $product)
                    <div class="bg-white border border-gray-100 rounded-xl p-3 cursor-pointer transition-all duration-300 hover:shadow-md hover:border-pink-300 hover:scale-[1.02] group"
                         x-show="(activeCategory === 'semua' || '{{ $product->category }}' === activeCategory) && ('{{ strtolower($product->name) }}'.includes(searchQuery.toLowerCase()) || searchQuery === '')"
                         x-transition
                         @click="addItem({{ $product->toJson() }})">
                        {{-- Product Image --}}
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="w-full h-24 object-cover rounded-lg mb-2 group-hover:opacity-90 transition-opacity"
                                 onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-24 bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg mb-2 items-center justify-center hidden">
                                <svg class="w-8 h-8 text-pink-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                        @elseif($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="w-full h-24 object-cover rounded-lg mb-2 group-hover:opacity-90 transition-opacity">
                        @else
                            <div class="w-full h-24 bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg mb-2 flex items-center justify-center">
                                @if($product->category === 'makanan')
                                    <span class="text-3xl">🍛</span>
                                @elseif($product->category === 'minuman')
                                    <span class="text-3xl">🥤</span>
                                @else
                                    <span class="text-3xl">🍿</span>
                                @endif
                            </div>
                        @endif
                        {{-- Info --}}
                        <h4 class="font-bold text-gray-800 text-xs leading-tight mb-1 truncate">{{ $product->name }}</h4>
                        <p class="text-pink-600 font-extrabold text-sm mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded-full
                                {{ $product->stock > 10 ? 'bg-green-50 text-green-600 border border-green-200' : ($product->stock > 0 ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-red-50 text-red-600 border border-red-200') }}">
                                Stok: {{ $product->stock }}
                            </span>
                            <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-md
                                {{ $product->category === 'makanan' ? 'bg-orange-50 text-orange-500' : ($product->category === 'minuman' ? 'bg-blue-50 text-blue-500' : 'bg-purple-50 text-purple-500') }}">
                                {{ ucfirst($product->category) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($products->isEmpty())
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <p class="text-gray-400 font-medium">Tidak ada produk tersedia.</p>
                </div>
            @endif
        </div>

        {{-- ============================== --}}
        {{-- AREA KANAN: Keranjang (Sticky) --}}
        {{-- ============================== --}}
        <div class="w-full lg:w-[40%] xl:w-1/3">
            <div class="lg:sticky lg:top-6 bg-pink-50/50 rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
                {{-- Header Keranjang --}}
                <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-5 py-3.5 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <span class="font-bold text-sm">Keranjang Belanja</span>
                    </div>
                    <span class="bg-white/20 text-white text-xs font-bold px-2.5 py-1 rounded-full" x-text="items.length + ' item'"></span>
                </div>

                <form action="{{ route('pos.checkout') }}" method="POST" class="flex flex-col">
                    @csrf

                    {{-- Customer Info --}}
                    <div class="px-5 pt-4 pb-2 space-y-2 border-b border-pink-100">
                        <div>
                            <label class="block text-[10px] font-bold text-pink-600 mb-1 uppercase tracking-wider">Nama Pelanggan / No Meja</label>
                            <input type="text" name="customer_name" x-model="customerName" placeholder="cth: Meja 5 / Budi"
                                   class="w-full border border-pink-200 focus:border-pink-500 focus:ring-pink-300 rounded-lg py-2 px-3 text-sm text-gray-800 transition-all">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[10px] font-bold text-pink-600 mb-1 uppercase tracking-wider">Tipe Order</label>
                                <select name="order_type" x-model="orderType"
                                        class="w-full border border-pink-200 focus:border-pink-500 focus:ring-pink-300 rounded-lg py-2 px-3 text-sm text-gray-800 transition-all">
                                    <option value="dine_in">🍽️ Dine In</option>
                                    <option value="takeaway">🥡 Takeaway</option>
                                    <option value="online">📱 Online</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-pink-600 mb-1 uppercase tracking-wider">Diskon (Rp)</label>
                                <input type="number" name="discount" x-model.number="discount" placeholder="0" min="0"
                                       class="w-full border border-pink-200 focus:border-pink-500 focus:ring-pink-300 rounded-lg py-2 px-3 text-sm text-gray-800 transition-all">
                            </div>
                        </div>
                    </div>

                    {{-- Cart Items --}}
                    <div class="px-5 py-4 min-h-[160px] max-h-[260px] overflow-y-auto">
                        <template x-if="items.length === 0">
                            <div class="h-full flex flex-col items-center justify-center py-8">
                                <svg class="w-12 h-12 text-pink-200 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <p class="text-pink-400 text-sm font-medium">Keranjang kosong</p>
                                <p class="text-pink-300 text-xs mt-0.5">Klik produk untuk menambahkan</p>
                            </div>
                        </template>

                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="flex items-center gap-3 mb-2.5 bg-white p-2.5 rounded-xl border border-pink-100 shadow-sm transition-all duration-200 hover:shadow-md">
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-sm text-gray-800 truncate" x-text="item.name"></p>
                                    <p class="text-xs font-semibold text-pink-600">Rp <span x-text="(item.price * item.quantity).toLocaleString('id-ID')"></span></p>
                                </div>
                                <div class="flex items-center gap-1 flex-shrink-0">
                                    <button type="button" class="w-7 h-7 rounded-full bg-pink-100 hover:bg-pink-200 text-pink-700 flex items-center justify-center font-bold text-sm transition-colors" @click="updateQty(index, item.quantity - 1)">−</button>
                                    <span class="text-sm font-bold w-7 text-center text-gray-800" x-text="item.quantity"></span>
                                    <button type="button" class="w-7 h-7 rounded-full bg-pink-100 hover:bg-pink-200 text-pink-700 flex items-center justify-center font-bold text-sm transition-colors" @click="updateQty(index, item.quantity + 1)">+</button>
                                </div>

                                {{-- Hidden Inputs --}}
                                <input type="hidden" :name="`items[${index}][product_id]`" :value="item.id">
                                <input type="hidden" :name="`items[${index}][quantity]`" :value="item.quantity">
                                <input type="hidden" :name="`items[${index}][price]`" :value="item.price">
                            </div>
                        </template>
                    </div>

                    {{-- Payment Area --}}
                    <div class="px-5 pb-5 border-t border-pink-100 pt-4">
                        {{-- Subtotal & Discount --}}
                        <div class="space-y-1 mb-2">
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span>Subtotal</span>
                                <span>Rp <span x-text="subtotal.toLocaleString('id-ID')"></span></span>
                            </div>
                            <div class="flex justify-between items-center text-sm text-red-500" x-show="discount > 0">
                                <span>Diskon</span>
                                <span>- Rp <span x-text="effectiveDiscount.toLocaleString('id-ID')"></span></span>
                            </div>
                        </div>

                        {{-- Total --}}
                        <div class="flex justify-between items-center font-bold text-lg text-gray-900 mb-4 bg-white p-3 rounded-xl border border-pink-200">
                            <span class="text-pink-700">Total</span>
                            <span class="text-pink-700">Rp <span x-text="total.toLocaleString('id-ID')"></span></span>
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-3">
                            <label class="block text-xs font-bold text-pink-700 mb-2 uppercase tracking-wider">Metode Bayar</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="cash" x-model="paymentMethod" class="peer sr-only">
                                    <div class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border-2 border-gray-200 text-sm font-semibold text-gray-500
                                                peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:text-pink-700 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        Cash
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="peer sr-only">
                                    <div class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border-2 border-gray-200 text-sm font-semibold text-gray-500
                                                peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:text-pink-700 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                        QRIS
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Nominal (Cash only) --}}
                        <div class="mb-3" x-show="paymentMethod === 'cash'" x-transition>
                            <label class="block text-xs font-bold text-pink-700 mb-1.5 uppercase tracking-wider">Nominal Diterima (Rp)</label>
                            <input type="number" name="paid_amount" x-model.number="paidAmount"
                                   class="w-full border border-pink-200 focus:border-pink-500 focus:ring-pink-300 rounded-xl py-2.5 px-4 text-lg font-bold text-gray-800 transition-all"
                                   min="0" :required="paymentMethod === 'cash'" :disabled="paymentMethod === 'qris'">

                            {{-- Kembalian --}}
                            <div class="flex justify-between items-center text-sm mt-2 font-bold p-2.5 bg-green-50 text-green-700 border border-green-200 rounded-xl">
                                <span>Kembalian:</span>
                                <span>Rp <span x-text="change.toLocaleString('id-ID')"></span></span>
                            </div>
                            <template x-if="paidAmount > 0 && paidAmount < total">
                                <p class="text-red-500 text-xs mt-1.5 font-semibold">⚠️ Nominal kurang dari total transaksi</p>
                            </template>
                        </div>

                        {{-- Hidden Input untuk QRIS agar tetap submit paid_amount = total --}}
                        <input type="hidden" name="paid_amount" :value="total" :disabled="paymentMethod === 'cash'">

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-bold rounded-xl shadow-lg shadow-pink-200 disabled:opacity-40 disabled:cursor-not-allowed transition-all duration-300 hover:shadow-xl hover:scale-[1.01] text-sm"
                                :disabled="!canSubmit()">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Selesai / Bayar
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Alpine.js Component Logic --}}
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cartData', () => ({
                items: [],
                paymentMethod: 'cash',
                paidAmount: '',
                searchQuery: '',
                activeCategory: 'semua',
                customerName: '',
                orderType: 'dine_in',
                discount: 0,

                get subtotal() {
                    return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                get effectiveDiscount() {
                    let d = parseInt(this.discount) || 0;
                    return Math.min(d, this.subtotal);
                },

                get total() {
                    return Math.max(0, this.subtotal - this.effectiveDiscount);
                },

                get change() {
                    if (this.paymentMethod === 'cash') {
                        let amount = parseFloat(this.paidAmount) || 0;
                        return Math.max(0, amount - this.total);
                    }
                    return 0;
                },

                addItem(product) {
                    let existingItem = this.items.find(i => i.id === product.id);
                    if (existingItem) {
                        if (existingItem.quantity < product.stock) {
                            existingItem.quantity++;
                        } else {
                            alert('Stok tidak mencukupi!');
                        }
                    } else {
                        if (product.stock > 0) {
                            this.items.push({
                                id: product.id,
                                name: product.name,
                                price: product.price,
                                stock: product.stock,
                                quantity: 1
                            });
                        }
                    }
                },

                updateQty(index, qty) {
                    let item = this.items[index];
                    if (qty > 0 && qty <= item.stock) {
                        item.quantity = qty;
                    } else if (qty <= 0) {
                        this.items.splice(index, 1);
                    } else if (qty > item.stock) {
                        alert('Stok maksimal adalah ' + item.stock);
                    }
                },

                canSubmit() {
                    if (this.items.length === 0) return false;
                    if (this.paymentMethod === 'qris') return true;
                    let amount = parseFloat(this.paidAmount) || 0;
                    if (amount < this.total) return false;
                    return true;
                }
            }))
        });
    </script>
    @endpush

</x-app-layout>
