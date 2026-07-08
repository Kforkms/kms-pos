{{-- Sidebar KMS POS - Pink Theme --}}
<div class="w-64 bg-white min-h-screen fixed flex flex-col justify-between border-r border-pink-100 shadow-lg z-50">
    {{-- Logo / Brand --}}
    <div>
        <div class="h-20 flex items-center justify-center border-b border-pink-100 bg-gradient-to-r from-pink-500 to-pink-600">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-xl font-extrabold text-white tracking-wide">KMS POS</span>
            </div>
        </div>

        {{-- Menu Label --}}
        <div class="px-6 pt-6 pb-2">
            <p class="text-[11px] font-bold text-pink-300 uppercase tracking-widest">Menu Utama</p>
        </div>

        {{-- Navigation Links --}}
        <nav class="px-4 space-y-1">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('dashboard')
                         ? 'bg-pink-50 text-pink-700 shadow-sm border border-pink-200'
                         : 'text-gray-500 hover:bg-pink-50 hover:text-pink-700 hover:translate-x-2 hover:shadow-sm' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- Kasir (POS) --}}
            <a href="{{ route('pos.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('pos.*') || request()->routeIs('shift.*')
                         ? 'bg-pink-50 text-pink-700 shadow-sm border border-pink-200'
                         : 'text-gray-500 hover:bg-pink-50 hover:text-pink-700 hover:translate-x-2 hover:shadow-sm' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                </svg>
                <span>Kasir (POS)</span>
            </a>

            {{-- Kitchen Display System --}}
            <a href="{{ route('kds.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('kds.*')
                         ? 'bg-pink-50 text-pink-700 shadow-sm border border-pink-200'
                         : 'text-gray-500 hover:bg-pink-50 hover:text-pink-700 hover:translate-x-2 hover:shadow-sm' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                </svg>
                <span>Kitchen (KDS)</span>
            </a>

            {{-- Manajemen Produk --}}
            <a href="{{ route('products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('products.*')
                         ? 'bg-pink-50 text-pink-700 shadow-sm border border-pink-200'
                         : 'text-gray-500 hover:bg-pink-50 hover:text-pink-700 hover:translate-x-2 hover:shadow-sm' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span>Manajemen Produk</span>
            </a>

            {{-- Menu Paket --}}
            <a href="{{ route('packages.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('packages.*')
                         ? 'bg-pink-50 text-pink-700 shadow-sm border border-pink-200'
                         : 'text-gray-500 hover:bg-pink-50 hover:text-pink-700 hover:translate-x-2 hover:shadow-sm' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
                <span>Menu Paket</span>
            </a>

            {{-- Laporan Transaksi --}}
            <a href="{{ route('reports.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('reports.*')
                         ? 'bg-pink-50 text-pink-700 shadow-sm border border-pink-200'
                         : 'text-gray-500 hover:bg-pink-50 hover:text-pink-700 hover:translate-x-2 hover:shadow-sm' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Laporan Transaksi</span>
            </a>
        </nav>

        {{-- Shift Section --}}
        @php
            $activeShift = \App\Models\Shift::where('user_id', Auth::id())->where('status', 'open')->first();
        @endphp
        @if($activeShift)
            <div class="px-4 mt-4">
                <div class="bg-green-50 border border-green-200 rounded-xl p-3">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-[10px] font-bold text-green-700 uppercase tracking-wider">Shift Aktif</span>
                    </div>
                    <p class="text-xs text-green-600 font-medium mb-2">
                        Sejak {{ $activeShift->opened_at ? $activeShift->opened_at->format('H:i') : '-' }}
                    </p>
                    <form action="{{ route('shift.close') }}" method="POST" onsubmit="return confirm('Yakin ingin menutup shift?')">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Tutup Shift
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    {{-- User Info & Logout --}}
    <div class="p-4 border-t border-pink-100 bg-pink-50/50">
        <div class="flex items-center gap-3 px-3 mb-3">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white font-bold text-sm shadow">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                <p class="text-[11px] text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-500 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
