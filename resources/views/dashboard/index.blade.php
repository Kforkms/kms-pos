<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    Dashboard
                </h2>
                <p class="text-sm text-gray-400 mt-1">Selamat datang kembali, {{ Auth::user()->name }}! 🎀</p>
            </div>
            <div class="text-sm text-gray-400">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    {{-- ============================================= --}}
    {{-- FILTER WAKTU --}}
    {{-- ============================================= --}}
    <div class="mb-6 flex justify-end">
        <form method="GET" action="{{ route('dashboard') }}" class="relative inline-block w-56">
            <select name="filter" onchange="this.form.submit()" class="block w-full appearance-none bg-white border border-pink-200 text-gray-700 py-2.5 px-4 pr-8 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 font-medium transition-all duration-300 cursor-pointer hover:border-pink-300">
                <option value="hari_ini" {{ (isset($filter) && $filter == 'hari_ini') ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu_ini" {{ (isset($filter) && $filter == 'minggu_ini') ? 'selected' : '' }}>Minggu Ini</option>
                <option value="tahun_ini" {{ (isset($filter) && $filter == 'tahun_ini') ? 'selected' : '' }}>Tahun Ini</option>
                <option value="semua_waktu" {{ (!isset($filter) || $filter == 'semua_waktu') ? 'selected' : '' }}>Semua Waktu</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-pink-500">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </form>
    </div>

    {{-- ============================================= --}}
    {{-- STATISTIK CARDS --}}
    {{-- ============================================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        {{-- Card: Total Penjualan --}}
        <div class="group bg-white rounded-2xl shadow-md border border-pink-100/50 p-6 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:scale-105 cursor-pointer relative overflow-hidden">
            <div class="absolute -top-4 -right-4 w-24 h-24 bg-pink-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-pink-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-pink-500 bg-pink-50 px-3 py-1 rounded-full">Pendapatan</span>
                </div>
                <p class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">Total seluruh penjualan</p>
            </div>
        </div>

        {{-- Card: Total Transaksi --}}
        <div class="group bg-white rounded-2xl shadow-md border border-purple-100/50 p-6 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:scale-105 cursor-pointer relative overflow-hidden">
            <div class="absolute -top-4 -right-4 w-24 h-24 bg-purple-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-purple-500 bg-purple-50 px-3 py-1 rounded-full">Transaksi</span>
                </div>
                <p class="text-2xl font-extrabold text-gray-800">{{ number_format($totalTransaksi) }}</p>
                <p class="text-xs text-gray-400 mt-1">Total transaksi tercatat</p>
            </div>
        </div>

        {{-- Card: Total Produk --}}
        <div class="group bg-white rounded-2xl shadow-md border border-sky-100/50 p-6 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:scale-105 cursor-pointer relative overflow-hidden">
            <div class="absolute -top-4 -right-4 w-24 h-24 bg-sky-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-sky-400 to-sky-600 rounded-2xl flex items-center justify-center shadow-lg shadow-sky-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-sky-500 bg-sky-50 px-3 py-1 rounded-full">Produk</span>
                </div>
                <p class="text-2xl font-extrabold text-gray-800">{{ number_format($totalProduk) }}</p>
                <p class="text-xs text-gray-400 mt-1">Produk terdaftar</p>
            </div>
        </div>

        {{-- Card: Rata-rata Transaksi --}}
        <div class="group bg-white rounded-2xl shadow-md border border-amber-100/50 p-6 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:scale-105 cursor-pointer relative overflow-hidden">
            <div class="absolute -top-4 -right-4 w-24 h-24 bg-amber-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-amber-500 bg-amber-50 px-3 py-1 rounded-full">Rata-rata</span>
                </div>
                <p class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">Rata-rata per transaksi</p>
            </div>
        </div>

    </div>

    {{-- ============================================= --}}
    {{-- AREA CHARTS --}}
    {{-- ============================================= --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">

        {{-- Line Chart: Pendapatan --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-md border border-pink-100/50 p-6 transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        📈 Pendapatan
                        @if(isset($filter))
                            @if($filter == 'hari_ini') (Hari Ini)
                            @elseif($filter == 'minggu_ini') (Minggu Ini)
                            @elseif($filter == 'tahun_ini') (Tahun Ini)
                            @else (Semua Waktu)
                            @endif
                        @else
                            (Semua Waktu)
                        @endif
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Grafik tren pendapatan</p>
                </div>
                <div class="w-3 h-3 bg-pink-400 rounded-full animate-pulse"></div>
            </div>
            <div class="relative" style="height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Pie Chart: Produk Terlaris --}}
        <div class="xl:col-span-1 bg-white rounded-2xl shadow-md border border-pink-100/50 p-6 transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">🏆 Produk Terlaris</h3>
                    <p class="text-xs text-gray-400 mt-1">Top 5 produk paling laku</p>
                </div>
                <div class="w-3 h-3 bg-purple-400 rounded-full animate-pulse"></div>
            </div>
            <div class="relative flex items-center justify-center" style="height: 300px;">
                <canvas id="bestSellerChart"></canvas>
            </div>
        </div>

    </div>

    {{-- ============================================= --}}
    {{-- QUICK ACTIONS --}}
    {{-- ============================================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('pos.index') }}"
           class="group bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl p-6 text-white shadow-lg shadow-pink-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl hover:scale-[1.02]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-lg">Buka Kasir</p>
                    <p class="text-sm text-pink-100">Mulai transaksi baru →</p>
                </div>
            </div>
        </a>

        <a href="{{ route('products.create') }}"
           class="group bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg shadow-purple-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl hover:scale-[1.02]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-lg">Tambah Produk</p>
                    <p class="text-sm text-purple-100">Daftarkan produk baru →</p>
                </div>
            </div>
        </a>

        <a href="{{ route('reports.index') }}"
           class="group bg-gradient-to-br from-sky-500 to-sky-600 rounded-2xl p-6 text-white shadow-lg shadow-sky-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl hover:scale-[1.02]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-lg">Lihat Laporan</p>
                    <p class="text-sm text-sky-100">Cek rekap penjualan →</p>
                </div>
            </div>
        </a>
    </div>

    {{-- ============================================= --}}
    {{-- CHART.JS SCRIPTS --}}
    {{-- ============================================= --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ========== LINE CHART - Pendapatan 7 Hari ==========
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');

            const revenueGradient = revenueCtx.createLinearGradient(0, 0, 0, 300);
            revenueGradient.addColorStop(0, 'rgba(236, 72, 153, 0.3)');
            revenueGradient.addColorStop(1, 'rgba(236, 72, 153, 0.01)');

            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['labels']) !!},
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: {!! json_encode($chartData['values']) !!},
                        borderColor: '#ec4899',
                        backgroundColor: revenueGradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ec4899',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        pointHoverBackgroundColor: '#db2777',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart',
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#f9fafb',
                            bodyColor: '#f9fafb',
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(ctx) {
                                    return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#9ca3af',
                                font: { size: 11, weight: '500' }
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(243, 244, 246, 1)',
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#9ca3af',
                                font: { size: 11 },
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                                    if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'rb';
                                    return 'Rp ' + value;
                                }
                            },
                            beginAtZero: true,
                        }
                    }
                }
            });

            // ========== DOUGHNUT CHART - Produk Terlaris ==========
            const pieCtx = document.getElementById('bestSellerChart').getContext('2d');

            const pieColors = [
                '#ec4899', // pink-500
                '#a855f7', // purple-500
                '#0ea5e9', // sky-500
                '#f59e0b', // amber-500
                '#10b981', // emerald-500
            ];

            const pieHoverColors = [
                '#db2777', // pink-600
                '#9333ea', // purple-600
                '#0284c7', // sky-600
                '#d97706', // amber-600
                '#059669', // emerald-600
            ];

            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($pieData['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($pieData['values']) !!},
                        backgroundColor: pieColors.slice(0, {!! count($pieData['labels']) !!}),
                        hoverBackgroundColor: pieHoverColors.slice(0, {!! count($pieData['labels']) !!}),
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 12,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeOutBounce',
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 16,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                color: '#374151',
                                font: { size: 11, weight: '500' }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#f9fafb',
                            bodyColor: '#f9fafb',
                            padding: 12,
                            cornerRadius: 12,
                            callbacks: {
                                label: function(ctx) {
                                    return ctx.label + ': ' + ctx.parsed + ' terjual';
                                }
                            }
                        }
                    }
                }
            });

        });
    </script>
    @endpush

</x-app-layout>
