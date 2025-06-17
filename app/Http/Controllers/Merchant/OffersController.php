<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Merchant\Offer;
use App\Models\Offering;
use Illuminate\Support\Facades\Storage;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('merchant.dashboard.offers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('merchant.dashboard.offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'price' => 'nullable|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:events,conference,restaurant,experiences',
            'category' => 'nullable|string|in:vip,one_day,several_days,reapeted',
            'has_chairs' => 'nullable|in:on,1,true',
            'chairs_count' => 'required_if:has_chairs,on|required_if:has_chairs,1|required_if:has_chairs,true|integer|min:0',
            //'user_id' => 'required|exists:users,id',

        ]);
        //dd($validated);
        $profilePicturePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uniqueName = 'image_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $profilePicturePath = $file->storeAs('', $uniqueName, 'public');

        }
        $has_chairs = false;
        if ($validated['has_chairs'] == 'ON') {
            $has_chairs = true;
        }
        $offer = Offering::create([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'image' => $profilePicturePath,
            'price' => $validated['price'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => $validated['status'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'additional_data' =>  null,
            'translations' =>  null,
            'has_chairs' => $has_chairs,
            'chairs_count' => $validated['chairs_count'],
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('merchant.dashboard.offer.index')->with('success', 'Offer created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       // return view('merchant.offers.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //return view('merchant.offers.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Logic to update the offer
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Logic to delete the offer
    }
}
