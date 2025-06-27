<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaysHistory;
use App\Http\Controllers\Controller;

class Merchantwithdraw extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = PaysHistory::whereHas('item', function($query) {
            $query->where('user_id', Auth::id());
        })->get();
        $totalPay = $reservations->filter(function ($reservation) {
            $type = $reservation->additional_data['type'] ?? null;
            return $type === 'pay';
        })->sum('amount');
        
        $totalRefund = $reservations->filter(function ($reservation) {
            $type = $reservation->additional_data['type'] ?? null;
            return $type === 'refund';
        })->sum('amount');
        
        // صافي الربح
        $netTotal = $totalPay - $totalRefund;
        // dd([
        //     'Total Pay' => $totalPay,
        //     'Total Refund' => $totalRefund,
        //     'Net Total' => $netTotal
        // ]);
        return view('merchant.dashboard.wallet_withdrawal', compact('reservations', 'totalPay', 'totalRefund', 'netTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
