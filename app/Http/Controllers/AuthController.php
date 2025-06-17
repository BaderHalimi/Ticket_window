<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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
            'other_business_type' => 'nullable|required_if:business_type,other|string|max:255',
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

            return redirect()->intended(route('merchant.dashboard.overview'))->with('success', 'Login successful');
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


    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url|max:255',
        ]);
        $user = User::findOrFail($id);
        $data = json_decode($user->additional_data ?? []);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $uniqueName = 'profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $profilePicturePath = $file->storeAs('', $uniqueName, 'public');

            if (!empty($data->profile_picture)) {
                Storage::disk('public')->delete($data->profile_picture);
                $data->profile_picture = null;
            }


            $data->profile_picture = $profilePicturePath;
        }
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $uniqueName = 'banner_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $bannerPath = $file->storeAs('', $uniqueName, 'public');

            if (!empty($data->banner)) {
                Storage::disk('public')->delete($data->banner);
                $data->banner = null;
            }

            $data->banner = $bannerPath;
            return back()->with('success', 'Profile updated successfully.');
            //$user->banner = $bannerPath;
        }
        dd($validated);
        $data->social_links = array_filter($request->input('social_links', []));
        $user->additional_data = json_encode($data);

        $user->save();

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


