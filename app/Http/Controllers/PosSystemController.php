<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaidReservation;
class PosSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = PaidReservation::where('user_id', Auth::id())
        ->where('additional_data->selling_type', 'pos')
        ->orderBy('created_at', 'desc')
        ->get();
    
        return view('merchant.dashboard.pos.pos', compact('reservations'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('merchant.dashboard.pos.create');
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
        $reservation = PaidReservation::findOrFail($id);
        //dd($reservation);
  
        
        return view('merchant.dashboard.pos.preview', compact('reservation'));
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
