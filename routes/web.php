<?php

use App\Http\Controllers\AuthController;
use App\Models\Offering;
use App\Models\User;
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
Route::get('/features', function () {
    return view('features');
})->name('features');
Route::get('/merchant', function () {
    return view('merchant');
})->name('merchant');
Route::get('/partners', function () {
    return view('partners');
})->name('partners');
Route::get('/wallet', function () {
    return view('wallet');
})->name('wallet');
Route::get('/roles', function () {
    return view('roles');
})->name('roles');
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');
Route::get('/customer/dashboard', function () {
    return view('customer.dashboard.index');
})->name('customer.dashboard');
Route::get('/customer/dashboard/tickets', function () {
    return view('customer.dashboard.tickets');
})->name('customer.dashboard.tickets');

Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');
Route::post('register', [AuthController::class,'store'])->middleware('guest')->name('signup');
Route::post('login', [AuthController::class,'login'])->middleware('guest')->name('singin');

Route::post('logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');

// Route::get('register', [AuthController::class,'showRegisterForm'])->middleware('guest')->name('register');

// Route::post('/logout', function () {
//     auth()->logout();
//     session()->regenerate();
//     return redirect()->route('home')->with('success', 'You have been logged out successfully.');
// })->middleware('auth')->name('logout');
// // login
// Route::get('login', [AuthController::class,'showLoginForm'])->middleware('guest')->name('login');
// Route::post('login', [AuthController::class,'login'])->middleware('guest')->name('signin');
// Route::post('register', [AuthController::class,'register'])->middleware('guest')->name('signup');
Route::get('dashboard', [AuthController::class,'dashboard'])->middleware('auth')->name('dashboard');

Route::get('/{id}',function($id){
    $merchant = User::findOrFail($id);
    return view('templates.tmplate1.index',compact('merchant'));
})->where(['id' => '[0-9]+'])->name('template1.index');
Route::get('/{id}/{offering}',function($id,Offering $offering){
    $merchant = User::findOrFail($id);
    if($offering->user_id != $merchant->id || $offering->status =='inactive'){
        abort(404);
    }
    return view('templates.tmplate1.item',compact('merchant','offering'));
})->where(['id' => '[0-9]+', 'offering' => '[0-9]+'])->name('template1.item');

Route::get('/{id}/cart',function($id){
    $merchant = User::findOrFail($id);
    $carts = Auth::user()->carts;
    return view('templates.tmplate1.cart',compact('merchant', 'carts'));
})->middleware('auth')->where(['id' => '[0-9]+'])->name('template1.cart');


Route::get('/checkout', [\App\Http\Controllers\Checkout::class, 'paid'])
    ->middleware('auth')
    ->name('template1.checkout.paid');
