<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'semua_waktu');
        $now = Carbon::now();

        $txQuery = Transaction::query();
        $itemQuery = TransactionItem::query();
        $productQuery = Product::query();

        if ($filter === 'hari_ini') {
            $txQuery->whereDate('created_at', $now->toDateString());
            $itemQuery->whereDate('created_at', $now->toDateString());
            $productQuery->whereDate('created_at', $now->toDateString());
        } elseif ($filter === 'minggu_ini') {
            $start = $now->copy()->startOfWeek();
            $end = $now->copy()->endOfWeek();
            $txQuery->whereBetween('created_at', [$start, $end]);
            $itemQuery->whereBetween('created_at', [$start, $end]);
            $productQuery->whereBetween('created_at', [$start, $end]);
        } elseif ($filter === 'tahun_ini') {
            $txQuery->whereYear('created_at', $now->year);
            $itemQuery->whereYear('created_at', $now->year);
            $productQuery->whereYear('created_at', $now->year);
        }

        // Statistik Utama
        $totalPenjualan = $txQuery->sum('total_amount') ?? 0;
        $totalTransaksi = $txQuery->count();
        $totalProduk = $productQuery->count();
        $rataRataTransaksi = $totalTransaksi > 0 ? $totalPenjualan / $totalTransaksi : 0;

        // Chart Data
        $chartLabels = [];
        $chartValues = [];

        if ($filter === 'hari_ini') {
            for ($i = 0; $i < 24; $i++) {
                $chartLabels[] = sprintf('%02d:00', $i);
                $chartValues[] = (float) Transaction::whereDate('created_at', $now->toDateString())
                    ->whereTime('created_at', '>=', sprintf('%02d:00:00', $i))
                    ->whereTime('created_at', '<', sprintf('%02d:00:00', $i + 1))
                    ->sum('total_amount');
            }
        } elseif ($filter === 'minggu_ini') {
            $start = $now->copy()->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $date = $start->copy()->addDays($i);
                $chartLabels[] = $date->translatedFormat('D, d M');
                $chartValues[] = (float) Transaction::whereDate('created_at', $date->toDateString())
                    ->sum('total_amount');
            }
        } elseif ($filter === 'tahun_ini') {
            for ($i = 1; $i <= 12; $i++) {
                $chartLabels[] = Carbon::createFromDate($now->year, $i, 1)->translatedFormat('M');
                $chartValues[] = (float) Transaction::whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $i)
                    ->sum('total_amount');
            }
        } else {
            // semua_waktu - 12 bulan terakhir
            for ($i = 11; $i >= 0; $i--) {
                $date = $now->copy()->subMonths($i);
                $chartLabels[] = $date->translatedFormat('M Y');
                $chartValues[] = (float) Transaction::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('total_amount');
            }
        }

        $chartData = [
            'labels' => $chartLabels,
            'values' => $chartValues,
        ];

        // Pie Data - 5 Produk Terlaris
        $bestSellers = $itemQuery->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->with('product')
            ->get();

        $pieData = [
            'labels' => $bestSellers->map(fn($item) => $item->product->name ?? 'Produk Dihapus')->values()->toArray(),
            'values' => $bestSellers->pluck('total_qty')->map(fn($v) => (int) $v)->toArray(),
        ];

        if (empty($pieData['labels'])) {
            $pieData = [
                'labels' => ['Belum ada data'],
                'values' => [1],
            ];
        }

        return view('dashboard.index', compact(
            'totalPenjualan',
            'totalTransaksi',
            'totalProduk',
            'rataRataTransaksi',
            'chartData',
            'pieData',
            'filter'
        ));
    }
}
