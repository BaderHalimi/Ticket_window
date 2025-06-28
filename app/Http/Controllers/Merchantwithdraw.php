<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaysHistory;
use App\Http\Controllers\Controller;
use App\Models\withdraws_log;

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
    
        $cleanReservations = $reservations->map(function ($reservation) {
            $reservation->additional_data = is_array($reservation->additional_data)
                ? $reservation->additional_data
                : json_decode($reservation->additional_data, true) ?? [];
            return $reservation;
        });
    
        $pendingReservations = $cleanReservations->filter(function ($r) {
            return ($r->additional_data['status'] ?? null) === 'pending';
        });
    
        $cancelledReservations = $cleanReservations->filter(function ($r) {
            return ($r->additional_data['status'] ?? null) === 'cancelled';
        });
    
        $checkedReservations = $cleanReservations->filter(function ($r) {
            return ($r->additional_data['status'] ?? null) === 'paid';
        });
    
        $netTotal = calculateNet($pendingReservations);
        $cancelledTotal = calculateNet($cancelledReservations);
        $checkedTotal = calculateNet($checkedReservations);
        //dd($pendingReservations);
        //dd($checkedReservations, $netTotal, $cancelledTotal, $checkedTotal, $pendingReservations, $cancelledReservations);
        $withdraws = withdraws_log::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->get();
        return view('merchant.dashboard.wallet_withdrawal', compact(
            'pendingReservations', 
            'cancelledReservations', 
            'checkedReservations', 
            'netTotal',
            'cancelledTotal',
            'checkedTotal',
            'withdraws'
        ));
    }
    
    /**
     * Helper لحساب صافي المبلغ من مجموعة
     * sum(pay) - sum(refund)
     */
    
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
        $transactionIds = (array) $request->input('transaction_ids', []);
        $jsonString = $transactionIds[0] ?? '[]';
        $decoded_transactions = json_decode($jsonString, true);
        $transaction_id =  collect($decoded_transactions)->pluck('transaction_id')->all();
        $transactions = PaysHistory::whereIn('transaction_id', $transaction_id)->get();
        $amount = (float) $request->input('amount');
        //dd($transactions);
        $withdraw = withdraws_log::create([
            'user_id' => Auth::id(),
            'withdraw_id' => uniqid('withdraw_'),
            'amount' => $amount,
            'status' => 'pending',
            'additional_data' => json_encode($transaction_id),
        ]);
        foreach ($transactions as $pay) {
            $data = $pay->additional_data ?? [];
            if (!is_array($data)) {
                $data = json_decode($data, true) ?? [];
            }
        
            $data['status'] = 'wait';  
        
            $pay->additional_data = $data;
            $pay->save();
        }
        
        dd($withdraw);

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
