<x-app-layout>
    <x-slot name="header">
        <div>
            {{-- Breadcrumbs --}}
            <nav class="flex items-center text-xs text-gray-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-pink-600 transition-colors">Home</a>
                <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('packages.index') }}" class="hover:text-pink-600 transition-colors">Menu Paket</a>
                <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-pink-600 font-semibold">Detail Paket</span>
            </nav>
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                Detail Menu Paket 🎁
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden flex flex-col md:flex-row">
            {{-- Image Side --}}
            <div class="w-full md:w-2/5 h-64 md:h-auto bg-gradient-to-br from-pink-50 to-pink-100 relative overflow-hidden flex-shrink-0">
                @if($package->image_url)
                    <img src="{{ asset($package->image_url) }}" alt="{{ $package->name }}"
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="w-full h-full flex items-center justify-center absolute inset-0 hidden">
                        <span class="text-7xl">🎁</span>
                    </div>
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-7xl">🎁</span>
                    </div>
                @endif
                <div class="absolute top-4 left-4 bg-pink-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                    PAKET COMBO
                </div>
            </div>

            {{-- Detail Side --}}
            <div class="p-6 md:p-8 flex-1">
                {{-- Title & Price --}}
                <div class="mb-4">
                    <h3 class="text-2xl font-extrabold text-gray-800 mb-1">{{ $package->name }}</h3>
                    <p class="text-3xl font-extrabold text-pink-600">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                </div>

                {{-- Description --}}
                @if($package->description)
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 italic">"{{ $package->description }}"</p>
                    </div>
                @endif

                {{-- Isi Paket --}}
                <div class="mb-8">
                    <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Isi Produk dalam Paket Ini
                    </h4>

                    <div class="space-y-3">
                        @foreach($package->products as $product)
                            <div class="flex items-center justify-between p-3 bg-pink-50/50 border border-pink-100 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">
                                        @if($product->category === 'makanan') 🍛 @elseif($product->category === 'minuman') 🥤 @else 🍿 @endif
                                    </span>
                                    <div>
                                        <p class="font-bold text-sm text-gray-800">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500">Harga normal: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <span class="bg-pink-600 text-white font-extrabold text-xs px-3 py-1.5 rounded-full shadow-sm">
                                    {{ $product->pivot->qty }}x
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('packages.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali
                    </a>
                    <a href="{{ route('packages.edit', $package->id) }}"
                       class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-md shadow-pink-200 transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Paket
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
