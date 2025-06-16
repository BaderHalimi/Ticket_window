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
    Route::get('checking',function(){
        return view('merchant.dashboard.checking');
    })->name('checking');
    Route::get('pos',function(){
        return view('merchant.dashboard.pos');
    })->name('pos');
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
    Route::get('reports_analysis',function(){
        return view('merchant.dashboard.reports_analysis');
    })->name('reports_analysis');

    Route::get('notification_management',function(){
        return view('merchant.dashboard.notification_management');
    })->name('notification_management');
    Route::get('message_center',function(){
        return view('merchant.dashboard.message_center');
    })->name('message_center');
    Route::get('wallet_withdrawal',function(){
        return view('merchant.dashboard.wallet_withdrawal');
    })->name('wallet_withdrawal');
    Route::get('branch_management',function(){
        return view('merchant.dashboard.branch_management');
    })->name('branch_management');
    Route::get('team_management',function(){
        return view('merchant.dashboard.team_management');
    })->name('team_management');
    Route::get('page_setup',function(){
        return view('merchant.dashboard.page_setup');
    })->name('page_setup');
    Route::get('policies_settings',function(){
        return view('merchant.dashboard.policies_settings');
    })->name('policies_settings');
    Route::get('languages_translation',function(){
        return view('merchant.dashboard.languages_translation');
    })->name('languages_translation');

    Route::get('api',function(){
        return view('merchant.dashboard.api');
    })->name('api');
    Route::get('activity_log',function(){
        return view('merchant.dashboard.activity_log');
    })->name('activity_log');


});
