<?php

use App\Http\Controllers\visitor\LoginController;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'login'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login_logic'])->middleware('guest')->name('login_logic');
Route::get('register', [LoginController::class, 'register'])->middleware('guest')->name('register');
Route::post('register', [LoginController::class, 'register_logic'])->middleware('guest')->name('register_logic');
Route::group(['middleware' => 'auth'], function () {
    Route::get('', function () {
        $events = Event::where('date','>',now())->where('status','active')->paginate(12);
        $categories = Category::where('type','events')->where('status','active')->get();
        return view('visitor.dashboard.index',compact('events','categories'));
    })->name('dashboard');
    Route::get('my_bookings', function () {
        $bookings = [];
        return view('visitor.dashboard.my_booking', compact('bookings'));
    })->name('my_bookings');
    Route::get('tickets', function () {
        $tickets = [];
        return view('visitor.dashboard.tickets', compact('tickets'));
    })->name('my_tickets');


    Route::get('explore_events', function () {
        $events = [];
        return view('visitor.dashboard.explore_events', compact('events'));
    })->name('my_events');

    Route::get('explore_restaurents', function () {
        $restaurents = [];
        return view('visitor.dashboard.explore_restaurents', compact('restaurents'));
    })->name('my_restaurents');
});


