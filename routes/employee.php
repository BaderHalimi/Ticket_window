<?php

use App\Http\Controllers\employee\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'login'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login_logic'])->middleware('guest')->name('login_logic');
Route::get('register', [LoginController::class, 'register'])->middleware('guest')->name('register');
Route::post('register', [LoginController::class, 'register_logic'])->middleware('guest')->name('register_logic');


Route::get('',function(){
    return view('employee.dashboard.index');
})->middleware('auth')->name('dashboard');




Route::get('/support',function(){
    return view('employee.dashboard.support');
})->middleware('auth')->name('support');

/*
Route::get('/employee', function () {
    $employee = [];
    return view('employee.dashboard.employees', compact('employee'));
})->name('employee');*/