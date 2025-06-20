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
        $offers = Offering::where('user_id', Auth::id())->get();
        return view('merchant.dashboard.offers.index',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offering =  \App\Models\Offering::create([
            'user_id' => Auth::id()
        ]);
        // return view('merchant.dashboard.offers.create',compact('offering'));
        return redirect()->route('merchant.dashboard.offer.edit', $offering->id)->with('success', 'Offer created successfully. Please fill in the details.');
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
        $offering = Offering::findOrFail($id);
        return view('merchant.dashboard.offers.edit', compact('offering'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $offer = Offering::findOrFail($id);

        // تحويل قيمة checkbox
        $request->merge([
            'has_chairs' => $request->has('has_chairs'),
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'price' => 'nullable|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:event,conference,restaurant,experience,events,conferences,experiences',
            'category' => 'nullable|in:vip,one_day,several_days,reapeted',
            'has_chairs' => 'boolean',
            'chairs_count' => 'required_if:has_chairs,true|integer|min:0',
        ]);

        $input = $request->only([
            'name',
            'location',
            'description',
            'price',
            'start_time',
            'end_time',
            'status',
            'type',
            'category',
            'has_chairs',
            'chairs_count',
        ]);

        if ($request->hasFile('image')) {
            $input['image'] = $request->file('image')->store('offers', 'public');
        }

        $offer->update($input);

        return redirect()->route('merchant.dashboard.offer.index')->with('success', 'تم تحديث الخدمة بنجاح.');
    }


    public function destroy($id)
    {
        $offer = Offering::findOrFail($id);
        if ($offer->user_id !== Auth::id()) {
            return redirect()->route('merchant.dashboard.offer.index')->with('error', 'Unauthorized action.');
        }
        if ($offer->image) {
            Storage::disk('public')->delete($offer->image);
        }
        $offer->delete();
        return redirect()->route('merchant.dashboard.offer.index')->with('success', 'Offer deleted successfully.');

    }
}
