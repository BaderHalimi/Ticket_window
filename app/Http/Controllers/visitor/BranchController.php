<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Category;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $restaurent, Branch $branch)

    {

        $user = $restaurent;
        if ($branch->restaurent_id != $user->id) {
            return redirect()->back()->with('error', 'You are not authorized to view this branch.');
        }
        return view('visitor.dashboard.restaurent.table_details', compact('branch', 'user'));
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
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(User $restaurant)
    {

        $branches = Branch::where('restaurent_id', $restaurant->id)->get();

        //dd($branches);
        $categories = Category::active()->where('type', 'events')->get();


        return view('visitor.dashboard.restaurent.branch_preview', compact('branches', 'categories','restaurant'));
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
