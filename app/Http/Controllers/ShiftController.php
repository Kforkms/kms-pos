<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Transaction;
use Carbon\Carbon;

class ShiftController extends Controller
{
    /**
     * Show the shift opening form, or redirect to POS if shift already open.
     */
    public function index()
    {
        $activeShift = Shift::where('user_id', auth()->id())
            ->where('status', 'open')
            ->first();

        if ($activeShift) {
            return redirect()->route('pos.index');
        }

        return view('pos.shift');
    }

    /**
     * Open a new shift.
     */
    public function open(Request $request)
    {
        $request->validate([
            'starting_cash' => 'required|integer|min:0',
        ]);

        // Close any existing open shifts for this user first
        Shift::where('user_id', auth()->id())
            ->where('status', 'open')
            ->update([
                'status' => 'closed',
                'closed_at' => Carbon::now(),
            ]);

        Shift::create([
            'user_id' => auth()->id(),
            'starting_cash' => $request->starting_cash,
            'status' => 'open',
            'opened_at' => Carbon::now(),
        ]);

        return redirect()->route('pos.index')->with('success', 'Shift berhasil dibuka! Selamat bekerja ✨');
    }

    /**
     * Close the active shift.
     */
    public function close(Request $request)
    {
        $activeShift = Shift::where('user_id', auth()->id())
            ->where('status', 'open')
            ->first();

        if (!$activeShift) {
            return redirect()->route('shift.index')->with('error', 'Tidak ada shift aktif.');
        }

        // Calculate total sales during this shift
        $totalSales = Transaction::where('shift_id', $activeShift->id)->sum('total_amount');
        $totalCashSales = Transaction::where('shift_id', $activeShift->id)
            ->where('payment_method', 'cash')
            ->sum('total_amount');
        $totalChangeGiven = Transaction::where('shift_id', $activeShift->id)
            ->where('payment_method', 'cash')
            ->sum('change_amount');

        $expectedCash = $activeShift->starting_cash + $totalCashSales - $totalChangeGiven;

        $activeShift->update([
            'ending_cash' => $expectedCash,
            'status' => 'closed',
            'closed_at' => Carbon::now(),
        ]);

        return redirect()->route('shift.index')->with('success',
            'Shift ditutup! Total penjualan: Rp ' . number_format($totalSales, 0, ',', '.') .
            ' | Uang laci: Rp ' . number_format($expectedCash, 0, ',', '.')
        );
    }
}
