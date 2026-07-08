<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                {{-- Breadcrumbs --}}
                <nav class="flex items-center text-xs text-gray-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-pink-600 transition-colors">Home</a>
                    <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-pink-600 font-semibold">Laporan Transaksi</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    Laporan Penjualan
                </h2>
            </div>
            <div class="flex items-center gap-2">
                {{-- Export Buttons --}}
                <a href="{{ route('reports.export.excel', request()->query()) }}"
                   class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-xl text-sm shadow-md shadow-green-200 transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Excel
                </a>
                <a href="{{ route('reports.export.pdf', request()->query()) }}"
                   class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-xl text-sm shadow-md shadow-red-200 transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    PDF
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Filter & Search Bar --}}
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-5 mb-6">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap items-end gap-3">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Cari Invoice / Kasir</label>
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik no. invoice atau nama kasir..."
                           class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:border-pink-400 focus:ring-pink-300 transition-all">
                </div>
            </div>
            {{-- Start Date --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                       class="border border-gray-200 rounded-xl py-2 px-3 text-sm focus:border-pink-400 focus:ring-pink-300 transition-all">
            </div>
            {{-- End Date --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                       class="border border-gray-200 rounded-xl py-2 px-3 text-sm focus:border-pink-400 focus:ring-pink-300 transition-all">
            </div>
            {{-- Buttons --}}
            <button type="submit"
                    class="inline-flex items-center gap-1.5 bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2 px-5 rounded-xl text-sm shadow-md shadow-pink-200 transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
            <a href="{{ route('reports.index') }}"
               class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all duration-200">
                Reset
            </a>
        </form>
    </div>

    {{-- Transaction Table --}}
    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100">
                        <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Invoice</th>
                        <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kasir</th>
                        <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Metode</th>
                        <th class="py-3.5 px-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $i => $trx)
                        <tr class="hover:bg-pink-50/40 transition-colors duration-200">
                            <td class="py-3.5 px-5 text-sm text-gray-400 font-medium">{{ $i + 1 }}</td>
                            <td class="py-3.5 px-5 text-sm text-gray-700">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td class="py-3.5 px-5">
                                <span class="text-sm font-bold text-gray-800 bg-gray-100 px-2.5 py-1 rounded-lg">{{ $trx->invoice_number }}</span>
                            </td>
                            <td class="py-3.5 px-5 text-sm text-gray-600">{{ $trx->user->name ?? '-' }}</td>
                            <td class="py-3.5 px-5 text-sm font-bold text-pink-700">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase
                                    {{ $trx->payment_method === 'cash' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                                    {{ $trx->payment_method }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-sm text-gray-500">
                                <ul class="space-y-0.5">
                                    @foreach($trx->transactionItems as $item)
                                        <li class="text-xs">
                                            <span class="text-gray-700 font-medium">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                                            <span class="text-gray-400">(x{{ $item->quantity }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p class="text-sm text-gray-400 font-medium">Tidak ada data transaksi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($transactions->isNotEmpty())
                <tfoot>
                    <tr class="bg-pink-50/80 border-t border-pink-100">
                        <td colspan="4" class="py-4 px-5 text-right text-sm font-bold text-pink-700 uppercase tracking-wider">Total Penjualan:</td>
                        <td colspan="3" class="py-4 px-5 text-lg font-extrabold text-pink-700">Rp {{ number_format($transactions->sum('total_amount'), 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</x-app-layout>
