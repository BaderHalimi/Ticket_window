<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\Tickets;


Route::prefix('dashboard')->as('dashboard.')->middleware(['auth:customer'])->group(function () {
    Route::get('/', function () {
        return view('customer.dashboard.index');
    })->name('overview');
    Route::get('tickets/print', [Tickets::class, 'tickets_print'])->name('tickets.print');
    Route::get('tickets/{id}/cancel', [Tickets::class, 'tickets_cancel'])->name('tickets.cancel');
    Route::get('tickets/payHistory', [Tickets::class, 'payHistory'])->name('tickets.payHistory');

    Route::resource('tickets', Tickets::class)->names('tickets');


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
