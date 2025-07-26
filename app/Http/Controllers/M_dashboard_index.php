<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\notifications;
class M_dashboard_index extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistics = get_statistics(Auth::id());
        $payments = $statistics["payments"];
        $offers = $statistics["offers"];
        $now = Carbon::now();
        $wallet = $statistics["wallet"]->balance;
        //dd($wallet);
        $activeReservationsCount = collect($statistics["offers"])
        ->flatMap(function ($offer) {
            return $offer->Reservations ?? [];
        })
        ->filter(function ($reservation) use ($now) {
            $data = json_decode($reservation->additional_data, true);
    
            if (!isset($data['selected_date']) || !isset($data['selected_time'])) {
                return false;
            }
    
            $datetimeStr = $data['selected_date'] . ' ' . $data['selected_time'];
            $startTime = Carbon::parse($datetimeStr);
    
            return $startTime->gt($now); 
        })
        ->count();

        $offersPercent = $statistics['offersPercent'];
        $topOfferData = $offersPercent->sortByDesc('percentage')->first();
        $topOffer = $topOfferData['offer']; 
        $topOfferName = $topOffer->name;   

        $notification = notifications::where("user_id", Auth::id())->paginate(10);
        //dd($notification);
        $today = Carbon::today();

        $todayPayments = $payments->filter(function ($payment) use ($today) {
            return Carbon::parse($payment->created_at)->isSameDay($today);
        })->sum("amount");

        //dd($todayPayments);   
        return view("merchant.dashboard.index",compact('todayPayments',"activeReservationsCount","wallet","topOfferName","notification"));
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

    /**
     * Display the specified resource.
     */
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
