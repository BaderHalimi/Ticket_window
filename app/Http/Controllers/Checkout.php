<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaidReservation;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
class Checkout extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    
    public function paid(){
        $user = Auth::user()->id;
    
        $cart = Cart::where('user_id', $user)->get();
    
        foreach ($cart as $item) {
            PaidReservation::create([
                'item_id' => $item->item_id, 
                'item_type' => $item->item_type, 
                'user_id' => $user, 
                'quantity' => $item->quantity,
                'price' => $item->price, 
                'discount' => $item->discount, 
                //'final_price' => $item->price - $item->discount, 
                'code' => uniqid('code_'), 
                'additional_data' => $item->additional_data,
            ]);
            $cart->where('id', $item->id)->delete(); 
        }
    
        return response()->json(['message' => 'Reservations created successfully'], 201);
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
