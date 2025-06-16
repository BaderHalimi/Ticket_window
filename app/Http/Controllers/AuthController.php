<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function index()
    {
        
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
        $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|in:restaurant,events,show,other',
            'phone' => 'nullable|string|max:15',
            'other_business_type' => 'required_if:business_type,other|string|max:255',
        ]);

        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'phone' => $request->phone,
            'additional_data' => [
                'other_business_type' => $request->business_type === 'other' ? $request->other_business_type : null,
                
            ],
            'role' => 'merchant', 

        ]);

        //Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $credentials =  $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        //$credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials) ) {
            //Auth::login();
            //dd(auth()->user());
            if (auth()->user()->is_accepted == true) {
            session()->regenerate();
            
            return redirect()->intended(route('customer.dashboard'))->with('success', 'Login successful');
            } else {
                auth()->logout();
                return back()->withErrors([
                    'email' => 'Your account is not accepted yet. Please wait for approval.',
                ]);
            }
        
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

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
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}
