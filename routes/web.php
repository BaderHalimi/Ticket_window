<?php

use App\Http\Controllers\AuthController;
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
Route::get('login', [AuthController::class,'showLoginForm'])->middleware('guest')->name('login');
Route::post('login', [AuthController::class,'login'])->middleware('guest')->name('signin');
Route::get('register', [AuthController::class,'showRegisterForm'])->middleware('guest')->name('register');
Route::post('register', [AuthController::class,'register'])->middleware('guest')->name('signup');
Route::get('dashboard', [AuthController::class,'dashboard'])->middleware('auth')->name('dashboard');
