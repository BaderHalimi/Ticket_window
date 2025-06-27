<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaidReservation;
use App\Models\PaysHistory;
use Illuminate\Support\Facades\Auth;
class ResController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = PaysHistory::whereHas('item', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        
        //dd($reservations);
        
        return view('merchant.dashboard.reservations.reservations', compact('reservations'));
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
        $reservation = PaysHistory::findOrFail($id);
        $offering = $reservation->item;
        $user = $reservation->user;
        $reservation->load('item', 'user');
        return view('merchant.dashboard.reservations.info', compact('reservation', 'offering', 'user'));
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
