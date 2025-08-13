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
    public function index($merchantid = null)
    {
        $finalID = can_enter($merchantid,"reservations_view");

        $reservations = PaysHistory::whereHas('item', function($query) use ($finalID) {
            $query->where('user_id', $finalID);
        })->get();

        
        //dd($reservations);
        //$merchant = $finalID;
        
        return view('merchant.dashboard.reservations.reservations', compact('reservations','merchantid'));
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
    public function show(string $id = null,$merchantid = null)
    {
        //dd($merchantid, Auth::id());
        //dd(fetch_Permetions(Auth::id(), $merchantid));
        //dd(has_Permetion(Auth::id(),"reservation_detail", $merchantid));
        $finalID = can_enter($merchantid,"reservation_detail");

        $reservation = PaysHistory::findOrFail($id);
        $offering = $reservation->item;
        $user = $reservation->user;
        $reservation->load('item', 'user');
        return view('merchant.dashboard.reservations.info', compact('reservation', 'offering', 'user','merchantid'));
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
