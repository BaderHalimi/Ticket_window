<?php

use Illuminate\Support\Facades\Route;

Route::get('dashboard',function(){
    return view('merchant.dashboard.index');
})->name('dasboard');
