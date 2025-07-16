<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaysHistory;
use App\Http\Controllers\Controller;
use App\Models\MerchantWallet;
use App\Models\withdraws_log;
use App\Models\User;
class Merchantwithdraw extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallet = MerchantWallet::where('merchant_id', Auth::id())->first();
        $withdraws = withdraws_log::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('merchant.dashboard.wallet_withdrawal', compact('wallet','withdraws'));
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
        $request->validate([
            'transaction_ids' => 'required|array',
            'amount' => 'required|numeric|min:1',
            'account_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s\.\-\'،]+$/u',
                ],
            'bank_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s\.\-\'،]+$/u',
                ],
            'iban' => [
                    'required',
                    'string',
                    'max:34',
                    'regex:/^[A-Z0-9]+$/',
                ],
            'swift' => [
                    'nullable',
                    'string',
                    'max:11',
                    'regex:/^[A-Z0-9]{8,11}$/',
                ],
            
        ]);

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
        notifcate(
            Auth::id(),
            'تم طلب السحب بنجاح' . $amount,
            'تستغرق العملية حوالي 24 ساعة او اكثر',
            [
                'type' => 'payment',
                'withdrawal' => true,
                'status' => 'pending',
                'recipient_id' => Auth::id(),
                'transaction_id' => $withdraw->withdraw_id,
                'amount' => $withdraw->amount,

            ],
        );
        
        //dd($withdraw);
        return redirect()->route('merchant.dashboard.withdraws.index')->with('success', 'تم إرسال طلب السحب بنجاح ✅');

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
