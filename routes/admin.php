<?php

use App\Http\Controllers\admin\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'login'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login_logic'])->middleware('guest')->name('login_logic');
Route::get('register', [LoginController::class, 'register'])->middleware('guest')->name('register');
Route::post('register', [LoginController::class, 'register_logic'])->middleware('guest')->name('register_logic');


Route::get('',function(){
    return view('admin.dashboard.index');
})->middleware('auth')->name('dashboard');


Route::get('/sellers', function () {
    $sellers = [];
    return view('admin.dashboard.sellers', compact('sellers'));
})->name('sellers');


Route::get('/employees', function () {
    $employees = [];
    return view('admin.dashboard.employees', compact('employees'));
})->name('employees');