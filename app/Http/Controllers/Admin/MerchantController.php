<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class MerchantController extends Controller
{
    public function index(){
        // $merchants = User::where('role', 'merchant')->paginate(30);
        return view('admin.dashboard.merchants.index');
    }

    public function loginAsMerchant($merchant)
    {
        // Find merchant by ID
        $user = User::where('role', 'merchant')->findOrFail($merchant);

        // Logout current user (admin)
        auth()->guard('merchant')->logout();

        // Login as merchant
        auth()->guard('merchant')->login($user);

        // Redirect to merchant dashboard
        return redirect()->route('merchant.dashboard.m.overview',['merchant'=>$user->id]);
    }
}
