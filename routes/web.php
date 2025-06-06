<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/login', function () {
    return redirect()->route('visitor.login');
})->middleware('guest')->name('login');

Route::post('/logout', function () {
    auth()->logout();
    session()->regenerate();
    return redirect()->route('home')->with('success', 'You have been logged out successfully.');
})->middleware('auth')->name('logout');
// login
Route::get('login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');
Route::post('login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (auth()->attempt($credentials)) {
        session()->regenerate();
        if (Auth::user()->role == 'admin') {
            return redirect()->intended('admin/')->with('success', 'You have been logged in successfully.');
        } elseif (Auth::user()->role == 'restaurant') {
            return redirect()->intended(route('restaurant.dashboard'))->with('success', 'You have been logged in successfully.');
        } elseif (Auth::user()->role == 'seller') {
            return redirect()->intended('seller/')->with('success', 'You have been logged in successfully.');
        } elseif (Auth::user()->role == 'visitor') {
            return redirect()->intended('visitor/')->with('success', 'You have been logged in successfully.');
        }
    }
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->middleware('guest')->name('visitor.login.post');
