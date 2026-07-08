<x-app-layout>
    <x-slot name="header">
        <div>
            {{-- Breadcrumbs --}}
            <nav class="flex items-center text-xs text-gray-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-pink-600 transition-colors">Home</a>
                <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-pink-600 font-semibold">Buka Shift</span>
            </nav>
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                Buka Shift Kasir 🔓
            </h2>
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

    <div class="max-w-lg mx-auto mt-8">
        <div class="bg-white rounded-2xl shadow-xl border border-pink-100 overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-8 py-6 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Mulai Shift Baru</h3>
                <p class="text-pink-100 text-sm mt-1">Masukkan modal awal laci kasir untuk memulai</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('shift.open') }}" method="POST" class="p-8">
                @csrf

                <div class="mb-6">
                    <label for="starting_cash" class="block text-xs font-bold text-pink-700 mb-2 uppercase tracking-wider">
                        Modal Awal (Rp)
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-sm">Rp</span>
                        <input type="number" name="starting_cash" id="starting_cash"
                               value="{{ old('starting_cash', 500000) }}"
                               class="w-full pl-12 pr-4 py-3.5 text-xl font-bold text-gray-800 border-2 border-pink-200 focus:border-pink-500 focus:ring-pink-300 rounded-xl transition-all"
                               min="0" required autofocus>
                    </div>
                    @error('starting_cash')
                        <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quick Amount Buttons --}}
                <div class="mb-6">
                    <p class="text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Pilih Cepat</p>
                    <div class="grid grid-cols-3 gap-2" x-data>
                        @foreach([200000, 300000, 500000, 750000, 1000000, 1500000] as $amount)
                            <button type="button"
                                    class="py-2 px-3 text-xs font-bold rounded-xl border-2 border-pink-100 text-pink-600 hover:bg-pink-50 hover:border-pink-300 transition-all duration-200"
                                    onclick="document.getElementById('starting_cash').value = {{ $amount }}">
                                {{ number_format($amount / 1000, 0) }}rb
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Info --}}
                <div class="bg-pink-50 border border-pink-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-pink-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-pink-700">Kasir: {{ Auth::user()->name }}</p>
                            <p class="text-xs text-pink-500 mt-0.5">{{ now()->translatedFormat('l, d F Y • H:i') }}</p>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-bold rounded-xl shadow-lg shadow-pink-200 transition-all duration-300 hover:shadow-xl hover:scale-[1.01] text-sm">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Buka Shift & Mulai Kasir
                    </span>
                </button>
            </form>
        </div>
    </div>

</x-app-layout>
