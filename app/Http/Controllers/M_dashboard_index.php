<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class M_dashboard_index extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistics = get_statistics(Auth::id());
        $payments = $statistics["payments"];
        $offers = $statistics["offers"]->Reservations;
        //dd($offers);
        $today = Carbon::today();

        $todayPayments = $payments->filter(function ($payment) use ($today) {
            return Carbon::parse($payment->created_at)->isSameDay($today);
        })->sum("amount");

        //dd($todayPayments);   
        return view("merchant.dashboard.index",compact('todayPayments'));
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
