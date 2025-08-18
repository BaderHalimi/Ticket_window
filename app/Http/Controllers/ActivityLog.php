<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\notifications;
class ActivityLog extends Controller
{
    public function index($merchantid = null){
        $finalID = can_enter($merchantid, "history_view");
        $notifications = notifications::where('user_id', $finalID)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('merchant.dashboard.activity_log', compact('notifications', 'finalID', 'merchantid'));
    }
}
