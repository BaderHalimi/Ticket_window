<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Merchant\BranchController;
use App\Http\Controllers\Merchant\OffersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Merchant\ResController;
use App\Http\Controllers\Merchantwithdraw;
use App\Http\Controllers\Page_statistics;
use App\Http\Controllers\PosSystemController;
use App\Models\Role;
use App\Http\Controllers\policies_settings;
use App\Http\Controllers\M_dashboard_index;
Route::prefix('dashboard')->as('dashboard.')->middleware(['auth:merchant'])->group(function(){
    Route::get('/',[M_dashboard_index::class,"index"])->name('overview');
    // Route::get('services',function(){
    //     return view('merchant.dashboard.services');
    // })->name('services');
    Route::resource('reservations',ResController::class)->names('reservations');
    Route::resource('withdraw',Merchantwithdraw::class)->names('withdraws');
    Route::resource('pos',PosSystemController::class)->names('pos');
    Route::resource('statistics',Page_statistics::class)->names('statistics');

    Route::get('work_in',function(){
        return view('merchant.dashboard.work_In');
    })->name('work_in');


    Route::get('checking',function(){
        return view('merchant.dashboard.checking');
    })->name('checking');

    Route::get('social_reservation',function(){
        return view('merchant.dashboard.social_reservation');
    })->name('social_reservation');
    Route::get('offers_codes',function(){
        return view('merchant.dashboard.offers_codes');
    })->name('offers_codes');
    Route::get('customer_reviews',function(){
        return view('merchant.dashboard.customer_reviews');
    })->name('customer_reviews');
    Route::get('intelligence_analytics',function(){
        return view('merchant.dashboard.intelligence_analytics');
    })->name('intelligence_analytics');
    // Route::get('reports_analysis',function(){
    //     return view('merchant.dashboard.reports_analysis');
    // })->name('reports_analysis');

    Route::get('notification_management',function(){
        return view('merchant.dashboard.notification_management');
    })->name('notification_management');
    Route::get('message_center',function(){
        return view('merchant.dashboard.message_center');
    })->name('message_center');
    Route::get('wallet_withdrawal',function(){
        return view('merchant.dashboard.wallet_withdrawal');
    })->name('wallet_withdrawal');
    Route::resource('branch', BranchController::class);
    Route::resource('offer', OffersController::class);

    // Route::get('branch_management',function(){
    //     return view('merchant.dashboard.index');
    // })->name('branch_management');
    Route::get('team_management',function(){
        return view('merchant.dashboard.team_management');
    })->name('team_management');
    Route::get('page_setup',function(){
        return view('merchant.dashboard.page_setup');
    })->name('page_setup');
    // Route::get('policies_settings',function(){
    //     return view('merchant.dashboard.policies_settings');
    // })->name('policies_settings');

    Route::resource('policies_settings', policies_settings::class)->names("policies_settings");

    Route::get('languages_translation',function(){
        return view('merchant.dashboard.languages_translation');
    })->name('languages_translation');

    Route::get('api',function(){
        return view('merchant.dashboard.api');
    })->name('api');


    // Route::get('activity_log',function(){
    //     return view('merchant.dashboard.activity_log');
    // })->name('activity_log');
    Route::resource('activity_log', \App\Http\Controllers\ActivityLog::class)->only(['index'])->names('activity_log');

    Route::post('update/{id}', [AuthController::class,'update'])->name('update');
    Route::post('updateS/{id}', [AuthController::class,'update_settings'])->name('update_settings');
    Route::post('updateP/{id}', [AuthController::class,'update_password'])->name('update_password');
    


});
Route::prefix('dashboard')->as('dashboard.m.')->middleware(['auth:merchant'])->group(function(){
    Route::get('m/{merchant}/',function($merchant){
        return view('merchant.dashboard.index',compact('merchant'));
    })->name('overview');
    // Route::get('services',function(){
    //     return view('merchant.dashboard.services');
    // })->name('services');
    Route::resource('m/{merchant}/reservations',ResController::class)->names('reservations');
    Route::resource('m/{merchant}/withdraw',Merchantwithdraw::class)->names('withdraws');
    Route::resource('m/{merchant}/pos',PosSystemController::class)->names('pos');
    Route::resource('m/{merchant}/statistics',Page_statistics::class)->names('statistics');


    Route::get('m/{merchant}/checking',function(){
        return view('merchant.dashboard.checking');
    })->name('checking');

    Route::get('m/{merchant}/social_reservation',function(){
        return view('merchant.dashboard.social_reservation');
    })->name('social_reservation');
    Route::get('m/{merchant}/offers_codes',function(){
        return view('merchant.dashboard.offers_codes');
    })->name('offers_codes');
    Route::get('m/{merchant}/customer_reviews',function(){
        return view('merchant.dashboard.customer_reviews');
    })->name('customer_reviews');
    Route::get('m/{merchant}/intelligence_analytics',function(){
        return view('merchant.dashboard.intelligence_analytics');
    })->name('intelligence_analytics');
    // Route::get('reports_analysis',function(){
    //     return view('merchant.dashboard.reports_analysis');
    // })->name('reports_analysis');

    Route::get('m/{merchant}/notification_management',function(){
        return view('merchant.dashboard.notification_management');
    })->name('notification_management');
    Route::get('m/{merchant}/message_center',function(){
        return view('merchant.dashboard.message_center');
    })->name('message_center');
    Route::get('m/{merchant}/wallet_withdrawal',function(){
        return view('merchant.dashboard.wallet_withdrawal');
    })->name('wallet_withdrawal');
    Route::resource('m/{merchant}/branch', BranchController::class);
    Route::resource('m/{merchant}/offer', OffersController::class);

    // Route::get('branch_management',function(){
    //     return view('merchant.dashboard.index');
    // })->name('branch_management');
    Route::get('m/{merchant}/team_management',function(){
        return view('merchant.dashboard.team_management');
    })->name('team_management');
    Route::get('m/{merchant}/page_setup',function(){
        return view('merchant.dashboard.page_setup');
    })->name('page_setup');
    Route::get('m/{merchant}/policies_settings',function(){
        return view('merchant.dashboard.policies_settings');
    })->name('policies_settings');
    Route::get('m/{merchant}/languages_translation',function(){
        return view('merchant.dashboard.languages_translation');
    })->name('languages_translation');

    Route::get('m/{merchant}/api',function(){
        return view('merchant.dashboard.api');
    })->name('api');
    // Route::get('m/{merchant}/activity_log',function(){
    //     return view('merchant.dashboard.activity_log');
    // })->name('activity_log');

    Route::resource('m/{merchant}/activity_log', \App\Http\Controllers\ActivityLog::class)->only(['index'])->names('activity_log');


    Route::post('m/{merchant}/update/{id}', [AuthController::class,'update'])->name('update');



});
