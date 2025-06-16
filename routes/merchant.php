<?php

use Illuminate\Support\Facades\Route;
Route::prefix('dashboard')->as('dashboard.')->group(function(){
    Route::get('/',function(){
        return view('merchant.dashboard.index');
    })->name('overview');
    Route::get('services',function(){
        return view('merchant.dashboard.services');
    })->name('services');
    Route::get('reservations',function(){
        return view('merchant.dashboard.reservations');
    })->name('reservations');
});
