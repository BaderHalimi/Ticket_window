<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\page_views;
use App\Models\PaysHistory;
use App\Models\PaidReservation;
use App\Models\withdraws_log;
use Illuminate\Support\Facades\Auth;
use App\Models\MerchantWallet;

class Page_statistics extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistics = get_statistics(Auth::id()); //Global function to get statistics
        $txns = $statistics['txns'];
        $wallet = $statistics['wallet'];
        $offers = $statistics['offers'];
        $offersPercent = $statistics['offersPercent'];
        $all_selles = $statistics['all_selles'];
        $all_refunds = $statistics['all_refunds'];
        $all_payments = $statistics['all_payments'];
        $couponLoss = 0;
        dd($all_selles, $all_refunds, $all_payments, $couponLoss);
        unset($statistics);
        //dd($wallet, $txns, $offers, $offersPercent);
        return view('merchant.dashboard.reports_analysis', compact('txns', 'wallet', 'offers', 'offersPercent'));
        
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
