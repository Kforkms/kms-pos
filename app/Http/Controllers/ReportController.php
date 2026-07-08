<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'transactionItems.product']);

        // Filter tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // Pencarian invoice / kasir
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $transactions = $query->latest()->get();

        return view('reports.index', compact('transactions'));
    }

    public function exportExcel(Request $request)
    {
        $transactions = $this->getFilteredTransactions($request);
        return Excel::download(new TransactionsExport($transactions), 'laporan-penjualan-kms-pos.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $transactions = $this->getFilteredTransactions($request);
        $totalPenjualan = $transactions->sum('total_amount');

        $pdf = Pdf::loadView('exports.transactions', compact('transactions', 'totalPenjualan'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-penjualan-kms-pos.pdf');
    }

    private function getFilteredTransactions(Request $request)
    {
        $query = Transaction::with(['user', 'transactionItems.product']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        return $query->latest()->get();
    }
}
