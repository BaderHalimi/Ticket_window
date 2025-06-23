<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'hello world';
})->name('home');

Route::prefix('dashboard')->as('dashboard.')->middleware(['auth:customer'])->group(function () {
    Route::get('/', function () {
        return view('customer.dashboard.index');
    })->name('overview');
    Route::get('/tickets', function () {
    return view('customer.dashboard.tickets');
})->name('tickets');
});




Route::get('/login', function () {
    return view('customer.auth.login');
})->middleware('guest')->name('login');
Route::get('/register', function () {
    return view('customer.auth.register');
})->middleware('guest')->name('register');
Route::post('register', [AuthController::class, 'store'])->middleware('guest')->name('signup');
Route::post('login', [AuthController::class, 'userLogin'])->middleware('guest')->name('singin');

Route::post('logout', [AuthController::class, 'userLogout'])->middleware('auth:customer')->name('logout');
