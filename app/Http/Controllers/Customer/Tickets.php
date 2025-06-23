<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PaidReservation;
//use App\Models\Cart;

class Tickets extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Reservations = PaidReservation::where('user_id', Auth::id())->get();
        return view('customer.dashboard.tickets', compact('Reservations'));
    }

    public function tickets_print(){
        $Reservations = PaidReservation::where('user_id', Auth::id())->get();
        return view('customer.dashboard.tickets_print', compact('Reservations'));
    }

    public function tickets_cancel($id){
        $reservation = PaidReservation::findOrFail($id);
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        /* هنا استرداد الفلوس لما يوفر لنا بوابة دفع */

        $reservation->delete();
        return redirect()->back()->with('success', 'Ticket cancelled successfully.');
    }
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
