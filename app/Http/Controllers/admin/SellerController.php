<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = User::where('role', 'seller')
            ->orWhere('role', 'restaurant')
            ->whereNotNull('additional_data')
            //->where('additional_data->status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->filter(function ($user) {
                $data = json_decode($user->additional_data);
                return isset($data->phone, $data->location) && !empty($data->phone) && !empty($data->location);
            });

        //dd($sellers);
        return view('admin.dashboard.sellers',compact('sellers'));
    }

    public function create()
    {
        
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
        $seller = User::findOrFail($id);
        $data = json_decode($seller->additional_data, true);
        return view('admin.dashboard.seller_details', compact('seller', 'data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
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
