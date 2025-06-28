<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaysHistory;
use App\Http\Controllers\Controller;
use App\Models\withdraws_log;

class Withdraw_checking extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = withdraws_log::where('status', 'pending')
            ->get();
        return view('admin.dashboard.withdraws.withdraws_check', compact('logs'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $log = withdraws_log::findOrFail($id);
        $log->load('user');

        $decoded_transactions = json_decode($log->additional_data, true);
        //$transaction_id =  collect($decoded_transactions)->pluck('transaction_id')->all();
        $transactions = PaysHistory::whereIn('transaction_id', $decoded_transactions)->get();
        //dd($transactions, $log, $decoded_transactions);



        return view('admin.dashboard.withdraws.withdraw_see', compact('log','transactions'));
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
        $log = withdraws_log::findOrFail($id);
        $log->status = 'completed';
        $log->save();

        $decoded_transactions = json_decode($log->additional_data, true);
        $transactions = PaysHistory::whereIn('transaction_id', $decoded_transactions)->get();
        
        foreach ($transactions as $transaction) {
            $data = $transaction->additional_data ?? [];
            if (!is_array($data)) {
                $data = json_decode($data, true) ?? [];
            }
            $data['status'] = 'paid';  
            $transaction->additional_data = json_encode($data);
            $transaction->save();
        }

        return redirect()->route('withdraw_checking.index')->with('success', 'Withdraw log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
