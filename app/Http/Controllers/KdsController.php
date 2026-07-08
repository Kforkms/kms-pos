<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class KdsController extends Controller
{
    /**
     * Kitchen Display System - Show today's orders with food/drink items.
     */
    public function index()
    {
        $todayOrders = Transaction::with(['transactionItems.product', 'user'])
            ->whereDate('created_at', Carbon::today())
            ->whereNotIn('status', ['ready', 'cancelled'])
            ->orderByDesc('created_at')
            ->get()
            ->filter(function ($transaction) {
                // Only show transactions that have at least one food/drink item
                return $transaction->transactionItems->contains(function ($item) {
                    return $item->product && in_array($item->product->category, ['makanan', 'minuman']);
                });
            });

        return view('kds.index', compact('todayOrders'));
    }

    /**
     * Update the status of a transaction in KDS.
     */
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,cancelled'
        ]);

        $transaction->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
