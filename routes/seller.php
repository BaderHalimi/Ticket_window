<?php

use App\Http\Controllers\seller\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'login'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login_logic'])->middleware('guest')->name('login_logic');
Route::get('register', [LoginController::class, 'register'])->middleware('guest')->name('register');
Route::post('register', [LoginController::class, 'register_logic'])->middleware('guest')->name('register_logic');
Route::get('',function(){
    $withdraw_balance = 20;
    $hold_balance = 10;
    $available_balance = 20;
    $total_balance = $withdraw_balance + $hold_balance;

    $total_events = 10;
    $total_bookings = 15;
    $total_tickets = 25;
    $total_canceled = 50;
    return view('seller.dashboard.index',compact('withdraw_balance','hold_balance','total_balance','available_balance',
        'total_events','total_bookings','total_canceled'));
})->middleware('auth')->name('dashboard');
