<table>
    {{-- Row 1: Title --}}
    <tr>
        <td colspan="7" style="text-align:center; font-size:16px; font-weight:bold; background-color:#db2777; color:#ffffff; padding:12px;">
            LAPORAN PENJUALAN - KMS POS
        </td>
    </tr>
    {{-- Row 2: Subtitle --}}
    <tr>
        <td colspan="7" style="text-align:center; font-size:10px; color:#6b7280; padding:6px;">
            Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB
        </td>
    </tr>
    {{-- Row 3: Spacer --}}
    <tr><td colspan="7"></td></tr>
    {{-- Row 4: Table Header --}}
    <tr>
        <th style="background-color:#ec4899; color:#ffffff; font-weight:bold; border:1px solid #f9a8d4; padding:8px; text-align:center;">No</th>
        <th style="background-color:#ec4899; color:#ffffff; font-weight:bold; border:1px solid #f9a8d4; padding:8px; text-align:center;">Tanggal</th>
        <th style="background-color:#ec4899; color:#ffffff; font-weight:bold; border:1px solid #f9a8d4; padding:8px; text-align:center;">No. Invoice</th>
        <th style="background-color:#ec4899; color:#ffffff; font-weight:bold; border:1px solid #f9a8d4; padding:8px; text-align:center;">Kasir</th>
        <th style="background-color:#ec4899; color:#ffffff; font-weight:bold; border:1px solid #f9a8d4; padding:8px; text-align:center;">Detail Item</th>
        <th style="background-color:#ec4899; color:#ffffff; font-weight:bold; border:1px solid #f9a8d4; padding:8px; text-align:center;">Metode</th>
        <th style="background-color:#ec4899; color:#ffffff; font-weight:bold; border:1px solid #f9a8d4; padding:8px; text-align:center;">Total (Rp)</th>
    </tr>
    {{-- Data Rows --}}
    @foreach($transactions as $i => $trx)
    <tr>
        <td style="border:1px solid #e5e7eb; padding:6px; text-align:center;">{{ $i + 1 }}</td>
        <td style="border:1px solid #e5e7eb; padding:6px; text-align:center;">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
        <td style="border:1px solid #e5e7eb; padding:6px;">{{ $trx->invoice_number }}</td>
        <td style="border:1px solid #e5e7eb; padding:6px;">{{ $trx->user->name ?? '-' }}</td>
        <td style="border:1px solid #e5e7eb; padding:6px;">
            @foreach($trx->transactionItems as $item){{ $item->product->name ?? 'Produk Dihapus' }} (x{{ $item->quantity }})@if(!$loop->last), @endif @endforeach
        </td>
        <td style="border:1px solid #e5e7eb; padding:6px; text-align:center; text-transform:uppercase;">{{ $trx->payment_method }}</td>
        <td style="border:1px solid #e5e7eb; padding:6px; text-align:right; font-weight:bold;">{{ number_format($trx->total_amount, 0, ',', '.') }}</td>
    </tr>
    @endforeach
    {{-- Footer Total --}}
    <tr>
        <td colspan="6" style="background-color:#fdf2f8; border:1px solid #f9a8d4; padding:8px; text-align:right; font-weight:bold; color:#be185d;">
            TOTAL PENJUALAN:
        </td>
        <td style="background-color:#fdf2f8; border:1px solid #f9a8d4; padding:8px; text-align:right; font-weight:bold; color:#be185d; font-size:13px;">
            Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
        </td>
    </tr>
</table>
