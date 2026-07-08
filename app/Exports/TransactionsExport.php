<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function view(): View
    {
        $totalPenjualan = $this->transactions->sum('total_amount');
        return view('exports.transactions', [
            'transactions' => $this->transactions,
            'totalPenjualan' => $totalPenjualan,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Header row styling (row 1-3 are title/info, row 4 is table header)
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DB2777']],
                'alignment' => ['horizontal' => 'center'],
            ],
            2 => [
                'font' => ['size' => 10, 'color' => ['rgb' => '6B7280']],
                'alignment' => ['horizontal' => 'center'],
            ],
            4 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'EC4899']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
