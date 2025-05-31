<?php

namespace App\Http\Controllers\seller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Category;


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branchs = Branch::all();

        return view('seller.dashboard.branches.index',compact('branchs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$categories = Category::active()->where('type', 'events')->get();
        return view('seller.dashboard.branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'name'=>'required|string|max:255',
            'location'=>'required|string|max:255',
            'tables'=>'required|integer',
            'hour_price'=>'required|numeric',
            'open_at' => 'nullable|date_format:H:i',
            'close_at' => 'required_with:open_at|date_format:H:i|after:open_at',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        } else {
            return "erorr";
        }

        $branch_sender = Branch::create([
            'image'=>$imagePath,
            'name'=>$validate['name'],
            'location'=>$validate['location'],
            'tables'=>$validate['tables'],
            'hour_price'=>$validate['hour_price'],
            'open_at'=>$validate['open_at'],
            'close_at'=>$validate['close_at'],
            'status'=>$validate['status'],
            'restaurent_id'=>Auth::user()->id
        ]);
        return redirect()->route('seller.branch.index')->with('success','branch was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(branch $branch)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(branch $branch)
    {
        //$categories = Category::active()->where('id', 'user')->get();
        return view("seller.dashboard.branches.edit",compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, branch $branch)
    {
        $validate = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'name'=>'nullable|string|max:255',
            'location'=>'nullable|string|max:255',
            'tables'=>'nullable|integer',
            'hour_price'=>'nullable|numeric',
            'open_at' => 'nullable|date_format:H:i',
            'close_at' => 'required_with:open_at|date_format:H:i|after:open_at',
            'status' => 'in:active,inactive',

        ]);


        $validated['restaurent_id'] = Auth::id();

        if ($request->hasFile('image')) {
            // File::delete(public_path($event->image));
            Storage::disk('public')->delete($branch->image);
            $validated['image'] = $request->file('image')->store('events', 'public');
        }else{
            $validated['image'] = $branch->image; // Keep the old image if no new one is uploaded
        }

        $branch->update($validated);

        return redirect()->route('seller.branch.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        if ($branch->image && Storage::disk('public')->exists($branch->image)) {
            Storage::disk('public')->delete($branch->image);
        }
            $branch->delete();
    
        return redirect()->route('seller.branch.index')->with('success', 'Branch deleted successfully.');
    }
    
}
