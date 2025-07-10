<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    public function index() {}

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
        $rules = [
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15|unique:users',
        ];
        if (Route::is('signup')) {
            $rules['business_name'] = 'nullable|string|max:255';
            $rules['business_type'] = 'nullable|in:restaurant,events,show,other';
            $rules['other_business_type'] = 'nullable|required_if:business_type,other|string|max:255';
        }
        $validated = $request->validate($rules);
        $validated['password'] = Hash::make($validated['password']);
        if (Route::is('signup')) {
            $validated['additional_data'] = [
                'other_business_type' => $request->business_type === 'other' ? $request->other_business_type : null,
            ];
            $validated['role'] = 'merchant';
        } elseif (Route::is('customer.signup')) {
            $validated['role'] = 'user';
        }
        $user = User::create($validated);

        //Auth::login($user);
        if ($validated['role'] == 'user') {
            Auth::guard('customer')->login($user);
        } elseif ($validated['role'] == 'merchant') {
            return redirect()->route('status')->with([
                'status' => 'pending',
            ]);
            // Auth::guard('merchant')->login($user);
        }
        return redirect()->intended(route('login'))->with('success', 'Registration successful!');

        // return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $credentials =  $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($request->guard == 'admin') {
            if (Auth::guard('admin')->attempt(array_merge($credentials, ['role' => 'admin']))) {
                session()->regenerate();
                return redirect()->intended(route('admin.dashboard.overview'))->with('success', 'Login successful');
            } else {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }
        } elseif ($request->guard == 'merchant') {
            if (Auth::guard('merchant')->attempt(array_merge($credentials, ['role' => 'merchant']))) {
                if (Auth::guard('merchant')->user()->status == 'active' ?? false) {
                    session()->regenerate();
                    return redirect()->intended(route('merchant.dashboard.overview'))->with('success', 'Login successful');
                } else {
                    $status = Auth::guard('merchant')->user()->status;
                    Auth::guard('merchant')->logout();
                    return redirect()->route('status')->with([
                        'status' => $status,
                    ]);
                    // return back()->withErrors([
                    //     'email' => 'Your account is not accepted yet. Please wait for approval.',
                    // ]);
                }
            } else
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
        } elseif ($request->guard == 'customer') {
            if (Auth::guard('customer')->attempt(array_merge($credentials, ['role' => 'user']))) {
                session()->regenerate();
                return redirect()->intended($request->redirect ?? route('customer.dashboard.overview'))->with('success', 'Login successful');
            } else {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    // public function userLogin(Request $request)
    // {
    //     $credentials =  $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //     ]);

    //     //$credentials = $request->only('email', 'password');
    //     if (Auth::guard('customer')->attempt($credentials)) {
    //         session()->regenerate();
    //         return redirect()->intended($request->redirect ?? route('customer.dashboard.overview'))->with('success', 'Login successful');
    //     }
    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }

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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url|max:255',
        ]);

        $user = User::findOrFail($id);

        // decode existing data safely
        $data = is_array($user->additional_data)
            ? (object) $user->additional_data
            : (object) (json_decode($user->additional_data, true) ?? []);

        // ✅ تحديث صورة البروفايل فقط إذا تم رفع صورة جديدة
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $uniqueName = 'profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $profilePicturePath = $file->storeAs('', $uniqueName, 'public');

            // حذف القديم إن وجد
            if (!empty($data->profile_picture)) {
                Storage::disk('public')->delete($data->profile_picture);
            }

            $data->profile_picture = $profilePicturePath;
        }

        // ✅ تحديث البانر فقط إذا تم رفعه
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $uniqueName = 'banner_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $bannerPath = $file->storeAs('', $uniqueName, 'public');

            if (!empty($data->banner)) {
                Storage::disk('public')->delete($data->banner);
            }

            $data->banner = $bannerPath;
        }

        // ✅ تحديث روابط التواصل فقط إذا وصلت قيمة
        if ($request->filled('social_links')) {
            $data->social_links = array_filter($request->input('social_links', []));
        }

        // ✅ حفظ json بدون تغيير القيم غير المعدلة
        $user->additional_data = (array) $data;
        $user->save();

        return back()->with('success', 'تم تحديث البيانات بنجاح.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function logout(Request $request)
    {
        Auth::guard('merchant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
    public function userLogout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
    public function dashboard()
    {
        // dd('hi');
        if (Auth::guard('merchant')->user() && Auth::guard('merchant')->user()->role = 'merchant') {
            return redirect()->route('merchant.dashboard.overview');
        }
        if (Auth::guard('customer')->user() && Auth::guard('customer')->user()->role = 'user')
            return redirect()->route('customer.dashboard.overview');
        return redirect()->route('login');
    }
}
