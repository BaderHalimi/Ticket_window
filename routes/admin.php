<?php

use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\Admin\MerchantController;
use App\Http\Controllers\admin\SellerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Withdraw_checking;
// Route::get('login', [LoginController::class, 'login'])->middleware('guest')->name('login');
// Route::post('login', [LoginController::class, 'login_logic'])->middleware('guest')->name('login_logic');
// Route::get('register', [LoginController::class, 'register'])->middleware('guest')->name('register');
// Route::post('register', [LoginController::class, 'register_logic'])->middleware('guest')->name('register_logic');

Route::prefix('dashboard')->as('dashboard.')->middleware(['auth:admin'])->group(function () {

    Route::get('', function () {
        return view('admin.dashboard.index');
    })->name('overview');
    Route::prefix('merchants')->as('merchants.')->group(function () {
        Route::get('/', [MerchantController::class, 'index'])->name('index');
    });
    Route::resource('withdraws', Withdraw_checking::class)
        //->middleware('auth:admin')
        ->names('withdraws');
});

Route::get('/login', function () {
    return view('admin.auth.login');
})->middleware('guest:admin')->name('login');
Route::post('login', [AuthController::class, 'login'])->middleware('guest:admin')->name('singin');
Route::post('logout', [AuthController::class, 'adminLogout'])->middleware('auth:admin')->name('logout');
