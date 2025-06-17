<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $branches = $user->branches()->paginate(10);
        return view('merchant.dashboard.branch.index', compact('branches'));
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
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        $user->branches()->create($request->only(['name', 'location']));
        // Branch::create($request->only(['name', 'location']));
        return redirect()->back()->with('success', 'تم إضافة الفرع بنجاح');
    }


    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $branch)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        $branch = $user->branches()->findOrFail($branch);
        $branch->name = $validated['name'];
        $branch->location = $validated['location'];
        $branch->save();
        return redirect()->back()->with('success', 'تم تعديل الفرع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($branch)
    {
        $user = Auth::user();
        $branch = $user->branches()->findOrFail($branch);
        $branch->delete();
        return redirect()->back()->with('success', 'تم حذف الفرع بنجاح');
    }
}
