<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();

        return view('seller.dashboard.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->where('type', 'events')->get();
        return view('seller.dashboard.events.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:now',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'total_tickets' => 'required|integer|min:1',
            'ticket_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);
        /*if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }else{
            return "erorr";
        }*/
        


        $event_sender = Event::create([
            'image'=> "",
            'name'=> $request->name,
            'description'=> $request->description,
            'category_id'=> $request->category_id,
            'date'=> $request->date,
            'location'=> $request->location,
            'total_tickets'=> $request->total_tickets,
            'ticket_price'=> $request->ticket_price,
            'status'=> $request->status,
            'user_id'=> Auth::user()->id
        ]);

        
        if ($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path(''),$imageName);

            $event_sender->image = $imageName;
            $event_sender->save();
        }else{return "erorr";}
        // Logic to store the event in the database

        return redirect()->route('seller.events.index')->with('success', 'Event created successfully.');
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
        $event = Event::findOrFail($id);
        $categories = Category::active()->where('type', 'events')->get();
        return view('seller.dashboard.events.edit',compact('event',"categories"));
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
        $event = Event::findOrFail($id);
        $event->delete();
        if ($event->image and File::exists(public_path($event->image))) {
            File::delete(public_path($event->image));
        }
        return redirect()->route('seller.events.index')->with("success","تم الحذف بنجاح");
    }
}
