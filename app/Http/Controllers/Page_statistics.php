<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\page_views;
use App\Models\PaysHistory;
use App\Models\PaidReservation;
use App\Models\withdraws_log;
use Illuminate\Support\Facades\Auth;

class Page_statistics extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = PaysHistory::whereHas('item', function($query) {
            $query->where('user_id', Auth::id());
        })->get();
        $all_res = PaidReservation::whereHas('offering', function($query) {
            $query->where('user_id', Auth::id());
        })->get();
        $peakHour = null;
        $peakCount = 0;
        if (!$all_res->isEmpty()){
            $grouped = $all_res->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->created_at)->format('H');
            });
            $hourlyCounts = $grouped->map(function ($items) {
                return $items->count();
            });
            $peakHour = $hourlyCounts->sortDesc()->keys()->first();
            $peakCount = $hourlyCounts->max();
        }
        $totalCount = $all_res->count();
        $grouped = $all_res->groupBy(function($reservation) {
            return $reservation->offering->name ?? 'غير معروف';
        });
        $stats = $grouped->map(function($items, $serviceName) use ($totalCount) {
            $count = $items->count();
            $percent = $totalCount > 0 ? round(($count / $totalCount) * 100, 1) : 0;
        
            return [
                'service' => $serviceName,
                'count' => $count,
                'percent' => $percent
            ];
        })->values();
        //dd($stats);        
        
        $views = page_views::where('merchant_id', Auth::id())->get();
        $viewsCount = $views->count();

        $cleanReservations = $reservations->map(function ($reservation) {
            $reservation->additional_data = is_array($reservation->additional_data)
                ? $reservation->additional_data
                : json_decode($reservation->additional_data, true) ?? [];
            return $reservation;
        });
    
        $pendingReservations = $cleanReservations->filter(function ($r) {
            return ($r->additional_data['status'] ?? null) === 'pending';
        });
    
        $cancelledReservations = $cleanReservations->filter(function ($r) {
            return ($r->additional_data['status'] ?? null) === 'cancelled';
        });
    
        $checkedReservations = $cleanReservations->filter(function ($r) {
            return ($r->additional_data['status'] ?? null) === 'paid';
        });
    
        $netTotal = calculateNet($pendingReservations);
        $cancelledTotal = calculateNet($cancelledReservations);
        $checkedTotal = calculateNet($checkedReservations);
        //dd($pendingReservations);
        //dd($checkedReservations, $netTotal, $cancelledTotal, $checkedTotal, $pendingReservations, $cancelledReservations);
        $withdraws = withdraws_log::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->get();
        //dd($viewsCount);
        return view('merchant.dashboard.reports_analysis', compact(
            'cleanReservations',
            'pendingReservations', 
            'cancelledReservations', 
            'checkedReservations', 
            'netTotal',
            'cancelledTotal',
            'checkedTotal',
            'withdraws',
            'viewsCount'
            , 'peakHour',
            'peakCount',
            'stats'
        ));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
