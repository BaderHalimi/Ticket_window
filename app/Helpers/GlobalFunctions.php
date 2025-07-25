<?php

//use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use App\Models\PaysHistory;
use App\Models\page_views;
use App\Models\User;
use App\Models\Offering;
use App\Models\notifications;
use App\Models\PaidReservation;
use App\Models\Permission;
use App\Models\Presence;
use App\Models\role_permission;
use App\Models\Role;
use App\Models\MerchantWallet;
use App\Models\Merchant\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

if (!function_exists('getCard')){
    function getCard()
    {
        $auth = Auth::user();
        $additional = $auth->additional_data ?? [];

        // بطاقة الدفع الحالية من الإندكس
        $paymentMethod = null;
        if (isset($additional['payment_method_index'], $additional['cards'])) {
            $index = $additional['payment_method_index'];
            if (is_numeric($index) && isset($additional['cards'][$index])) {
                $paymentMethod = $additional['cards'][$index]['type'] ?? null;
                return $paymentMethod;

            }

        }


        return null;
    }
}

if (!function_exists('logPayment')) {
    function logPayment(array $data)
    {
        $wallet = Offering::where('id', $data['item_id'])->first()->user->wallet;
        //dd($wallet);
        $balance = (float) $wallet->balance;
        $amount = (float) $data['amount'];
        if ($data['additional_data']['type'] === 'pay') {
            $wallet->balance = $balance + $amount;
        } elseif ($data['additional_data']['type'] === 'refund') {
            $wallet->balance = $balance - $amount;
        }
        $wallet->save();
        $txn =  PaysHistory::create([
            'user_id'         => $data['user_id'] ?? Auth::user()->id,
            'item_id'         => $data['item_id'] ?? null,
            'wallet_id'      => $wallet->id,
            'transaction_id'  => $data['transaction_id'],
            'payment_method'  => getCard(),
            'amount'          => $data['amount'],
            'additional_data' => $data['additional_data'] ?? [],

        ]);


    }
}
if (!function_exists('calculateNet')) {

function calculateNet($collection)
{
    $totalPay = $collection->filter(function ($r) {
        return ($r->additional_data['type'] ?? null) === 'pay';
    })->sum('amount');

    $totalRefund = $collection->filter(function ($r) {
        return ($r->additional_data['type'] ?? null) === 'refund';
    })->sum('amount');

    return $totalPay - $totalRefund;
}
}
if (!function_exists('set_viewed')) {
    function set_viewed($merchant_id)
    {
        $user = Auth::guard('customer')->user();

        //dd(($user));
        if (!$user) {
            //dd($user);
            return;
        }

        $page_url = request()->url();
        $ip = request()->ip();

        $existing = page_views::where('user_id', $user->id)
            ->where('page_url', $page_url)
            ->where('ip_address', $ip)
            ->first();

        if ($existing) {
            if ($existing->created_at->diffInMinutes(now()) <= 1440) {
                $existing->created_at = now();
                $existing->save();
                return;
            }
        }

        //dd($existing, $user, $page_url, $ip, $merchant_id);
        page_views::create([
            'user_id'        => $user->id,
            'ip_address'     => $ip,
            'page_url'       => $page_url,
            'merchant_id'    => $merchant_id,
            'additional_data'=> json_encode(['timestamp' => now()]),
        ]);
    }
}

if (!function_exists('notifcate')) {
    function notifcate( $user_id,$title, $body, $data)
    {


        $notification = notifications::create([

            'subject' => $title,
            'user_id' => $user_id,
            'message'  => $body,
            'data'  => json_encode($data),
            'type' => 'alert',
            'is_read' => false,
            'additional_data' => json_encode($data),//link * image
        ]);

        // Optionally, you can trigger an event or perform additional actions here
        // event(new NotificationCreated($notification));

        return $notification;

    }
}

// if (!function_exists('hasEssentialFields')) {

//     function isFilled($value): bool
//     {
//         if (is_null($value)) return false;
//         if (is_array($value)) return count($value) > 0;
//         return trim((string)$value) !== '';
//     }

//     function hasEssentialFields(int $offerId): array
//     {
//         $offer = \App\Models\Offering::find($offerId);

//         if (!$offer) {
//             return [
//                 'status' => false,
//                 'fields' => [],
//                 'message' => "Offer not found for ID: $offerId"
//             ];
//         }

//         $features = $offer->features ?? [];

//         $checks = [
//             'name'                => isFilled($offer->name),
//             'description'         => isFilled($offer->description),
//             'location'            => isFilled($offer->location),
//             'price' => ($offer->price && $offer->price > 0),

//             //'services_type'       => isFilled($features['services_type'] ?? null),
//             //'base_price'          => isFilled($features['base_price'] ?? null),
//             'booking_duration'    => isFilled($features['booking_duration'] ?? null),
//             'booking_unit'        => isFilled($features['booking_unit'] ?? null),

//             'pricing_packages'    => !empty($features['pricing_packages']) &&
//                                       isFilled($features['pricing_packages'][0]['label'] ?? null),

//             'gallery'             => !empty($features['gallery']) &&
//                                       isFilled($features['gallery'][0] ?? null),
//         ];

//         $allOk = !in_array(false, $checks, true);

//         return [
//             'status' => $allOk,
//             'fields' => $checks
//         ];
//     }
// }

if (!function_exists('hasEssentialFields')) {

    function isFilled($value): bool
    {
        if (is_null($value)) return false;
        if (is_array($value)) return count($value) > 0;
        return trim((string)$value) !== '';
    }

    function checkTimeValidity($offerId): bool
    {
        $time = fetch_time($offerId);
        if (!$time) return false;

        $type = $time['type'] ?? null;
        $data = $time['data'] ?? [];

        if ($type === 'service') {
            return count($data) > 0;
        }

        if ($type === 'events') {
            if (count($data) === 0) return false;

            foreach ($data as $event) {
                if (
                    empty($event['start_date']) ||
                    empty($event['start_time']) ||
                    empty($event['end_date']) ||
                    empty($event['end_time'])
                ) {
                    return false;
                }
            }
            return true;
        }

        return false;
    }

    function hasEssentialFields(int $offerId): array
    {
        $offer = \App\Models\Offering::find($offerId);

        if (!$offer) {
            return [
                'status' => false,
                'fields' => [],
                'message' => "Offer not found for ID: $offerId"
            ];
        }

        $features = $offer->features ?? [];
        $branch_for_ser = true;
        if($offer->type == "services"){
            $branch_for_ser=isFilled($features['selected_branches'] ?? null);
        }
        $checks = [
            'name'                => isFilled($offer->name),
            'description'         => isFilled($offer->description),
            'location'            => isFilled($offer->location),
            'image'                 => isFilled($offer->image),
            'price'               => ($offer->price && $offer->price > 0),


            'booking_duration'    => isFilled($features['booking_duration'] ?? null),
            'booking_unit'        => isFilled($features['booking_unit'] ?? null),

            'max_users_unit'        => isFilled($features['max_user_unit'] ?? null),
            'max_users_per_time'        => isFilled($features['max_user_time'] ?? null),
            'branch' => $branch_for_ser,
            // 'pricing_packages'    => !empty($features['pricing_packages']) &&
            //                           isFilled($features['pricing_packages'][0]['label'] ?? null),
            
            
            // 'gallery'             => !empty($features['gallery']) &&
            //                           isFilled($features['gallery'][0] ?? null),

            'time'                => checkTimeValidity($offerId),
        ];

        $allOk = !in_array(false, $checks, true);

        return [
            'status' => $allOk,
            'fields' => $checks
        ];
    }
}


if (!function_exists('fetch_time')) {
    function fetch_time($offer_id)
    {
        $offer = Offering::find($offer_id);

        if (!$offer || !$offer->features) {
            return null;
        }

        $features = $offer->features;
        //dd($features);
        if (($offer->type ?? null) === 'services') {
            $data = [];

            foreach ($features['days'] ?? [] as $day => $info) {
                $data[$day] = [
                    'enabled' => true,
                    'from' => $info['from'] ?? null,
                    'to' => $info['to'] ?? null,
                ];

            }


            return [
                'type' => 'service',
                'data' => $data,
                'max_reservation_date' => $features['max_reservation_date'] ?? null,
            ];
        }

        if (($offer->type ?? null) === 'events') {
            $data = [];

            foreach ($features['calendar'] ?? [] as $event) {
                $data[] = [
                    'start_date' => $event['start_date'] ?? null,
                    'start_time' => $event['start_time'] ?? null,
                    'end_date' => $event['end_date'] ?? null,
                    'end_time' => $event['end_time'] ?? null,

                ];
            }

            return [
                'type' => 'events',
                'data' => $data,
            ];
        }

        return null;
    }
}

// if (!function_exists("set_presence")){
//     function set_presence($reservation)
//     {
//         //$user = User::find($user_id);
//         //$reservation = $reservation;//PaysHistory::find($transaction_id);
//         if ( !$reservation) {
//             return false;
//         }
//         $set_presenting = Presence::create([
//             'user_id' => $reservation->user_id,
//             'reservation_id' => $reservation->id,//PaidRes
//             'item_id'=> $reservation->item_id ?? null,
//             'additional_data' => json_encode([
//                 'payment_method' => $reservation->payment_method,
//                 'amount' => $reservation->price,
//                 'ip_address' => request()->ip(),
//                 'code' => $reservation->code ?? null,

//             ]),
//         ]);
//         // dd($set_presenting);
//         return true;
//     }
// }

if (!function_exists('fetch_Permetions')){
    function fetch_Permetions($user_id)
    {
        $Roles_user = role_permission::with('role')->where('employee_id', $user_id)->get();

        $result = [];

        foreach ($Roles_user as $roleUser) {

            if (!$roleUser->role) {
                continue;
            }

            $roleName = $roleUser->role->name;

            $add = json_decode($roleUser->role->additional_data, true);
            $permIds = $add['permissions'] ?? [];

            $permissions = Permission::whereIn('id', $permIds)->pluck('key')->toArray();

            $result[] = [
                'role_name' => $roleName,
                'permissions' => $permissions
            ];

        }
        //dd($result);

        return $result;
    }
}
if(!function_exists("has_Permetion")){
    function has_Permetion($user_id, $perm_key)
    {
        $roles = fetch_Permetions($user_id);
        foreach ($roles as $role) {
            if (in_array($perm_key, $role['permissions'])) {
                return true;
            }
        }
        return false;
    }
}


if(!function_exists("is_work")){
    function is_work($user_id){
        $user = User::find($user_id);
        if (!$user){
            return;
        }

        $data = $user->additional_data['workIn'] ?? [];
        if (empty($data)) {
            return false;
        }

        return true;

    }
}
if(!function_exists("work_in")){
    function work_in($user_id){
        $user = User::find($user_id);
        if (!$user){
            return;
        }

        $data = $user->additional_data['workIn'] ?? [];
        if (empty($data)) {
            //dd("not");
            return ;
        }
        //dd($data, Auth::id(), $user_id);
        // if (isset($data['workIn']) && is_array($data['workIn'])) {
        //     return in_array(Auth::id(), $data['workIn']);
        // }
        return $data;

    }
}

if (!function_exists('clear_offers')) {
    function clear_offers($collection)
    {
        foreach ($collection as $offer) {
            if (!in_array("true",hasEssentialFields($offer->id)['fields'])) {
                $offer->delete();
            }

        }
    }
}

if(!function_exists('set_presence')){
    function set_presence($id){
        $Res = PaidReservation::Find($id);
        if (!$Res) {
            return "this res is'nt exist";
        }
        $quantity = (int)$Res->quantity ?? 1;
        if ($quantity <= 0) {
            return "this res is'nt exist";
        }
        $quantity -= 1;
        $Res->quantity = $quantity;
        $Res->save();

        $presence = Presence::create([
            'user_id' => $Res->user_id,
            'reservation_id' => $Res->id,
            'item_id' => $Res->item_id ?? null,
            'additional_data' => [],
        ]);
        notifcate($Res->user_id, 'success', 'تم تسجيل الحضور بنجاح', [
            'title' => 'حضور',
            'text' => 'تم تسجيل حضورك بنجاح.',
        ]);
        if (!$presence) {
            return "presence not created";
        }
        return true;
    }
}


if (!function_exists('Create_Wallet')){
    function Create_Wallet($user_id){
        MerchantWallet::create([
            'merchant_id' => $user_id,
            'balance' => 0,
            'locked_balance' => 0,
            'withdrawn_total' => 0,
            'additional_data' => [],
        ]);
    }
}

if(!function_exists('get_statistics')){
    function get_statistics($user_id)
    {
        $wallet = MerchantWallet::where('merchant_id', $user_id)->first();
        if (!$wallet) {
            $wallet = MerchantWallet::create([
                'merchant_id' => $user_id,
                'balance' => 0,
                'locked_balance' => 0,
                'withdrawn_total' => 0,
                'additional_data' => [],
            ]);
        }
        $txns = $wallet->transactions()->get();
        $offers = $txns->map(function ($txn) {return $txn->item;})->unique('id');
        $offersPercent = $offers->map(function ($offer) use ($txns) {
            $offerTxns = $txns->where('item_id', $offer->id);
            $totalAmount = $offerTxns->sum('amount');
            return [
                'offer' => $offer,
                'total_amount' => $totalAmount,
                'percentage' => round($totalAmount / $txns->sum('amount') * 100, 2),
            ];
        });
        $refunds = $txns->filter(function ($txn) {return $txn->additional_data['type'] === 'refund';});
        $payments = $txns->filter(function ($txn) {return $txn->additional_data['type'] === 'pay';});
        return [
            'wallet' => $wallet,
            'txns' => $txns,
            'offers' => $offers,
            'offersPercent' => $offersPercent,
            'refunds' => $refunds,
            'payments' => $payments,

        ];
    }
}

if (!function_exists('Peak_Time')) {
    function Peak_Time($user_id)
    {
        $from = Carbon::now()->subDays(30);

        $purchases = DB::table('paid_reservations')
            ->join('offerings', 'paid_reservations.item_id', '=', 'offerings.id')
            ->where('offerings.user_id', $user_id)
            ->where('paid_reservations.created_at', '>=', $from)
            ->selectRaw('DAYOFWEEK(paid_reservations.created_at) as day, HOUR(paid_reservations.created_at) as hour, COUNT(*) as total')
            ->groupBy('day', 'hour')
            ->orderBy('day')
            ->orderBy('hour')
            ->get();

        $days = [1 => 'الأحد', 2 => 'الاثنين', 3 => 'الثلاثاء', 4 => 'الأربعاء', 5 => 'الخميس', 6 => 'الجمعة', 7 => 'السبت'];
        $hours = range(0, 23);

        $result = [];

        foreach ($days as $dayNum => $dayName) {
            $row = [];
            foreach ($hours as $hour) {
                $value = $purchases->firstWhere(fn($p) => $p->day == $dayNum && $p->hour == $hour)->total ?? 0;
                $row[] = $value;
            }
            $result[$dayName] = $row;
        }

        return $result;
    }

}
if (!function_exists('pending_reservations')) {
    function pending_reservations($item)
    {
        $item = Offering::find($item);
        if (!$item) {
            return [];
        }
        $reservations = $item->Reservations;
        return $reservations;

    }
}
if (!function_exists('pending_reservations_at')) {
    function pending_reservations_at($item, $unit = 'day', $branch = null)
    {
        $item = Offering::find($item);
        if (!$item) {
            return [];
        }

        $now = Carbon::now();

        $reservations = $item->Reservations->filter(function ($reservation) use ($now, $unit, $branch) {
            $createdAt = Carbon::parse($reservation->created_at);
            $data = json_decode($reservation->additional_data, true);

            if ($branch !== null && (!isset($data['branch']) || $data['branch'] != $branch)) {
                return false;
            }

            switch ($unit) {
                case 'minute':
                    return $createdAt->diffInMinutes($now) === 0;
                case 'hour':
                    return $createdAt->diffInHours($now) === 0;
                case 'week':
                    return $createdAt->isSameWeek($now);
                case 'day':
                default:
                    return $createdAt->isSameDay($now);
            }
        })->values();

        return $reservations;
    }
}




if (!function_exists('can_booking_now')){
    function can_booking_now($offer_id,$branch = null)
    {
        $offer = Offering::find($offer_id);
        if (!$offer->features["max_user_unit"]){
            return false;
        }
        $unit = $offer->features["max_user_unit"];
        $max_limit = $offer->features["max_user_time"] ?? 0;
        $res = pending_reservations_at($offer_id, $unit, $branch);
        //dd($res);
        if ($res->isEmpty()) {
            return true;
        }
        //$res->count("quantity");
        $total_quantity = $res->sum("quantity");
        if ($total_quantity >= $max_limit) {
            return false;
        }
        return true;

    }
}
if (!function_exists("get_quantity")) {
    function get_quantity($offer_id,$branch = null)
    {
        $offer = Offering::find($offer_id);
        if (!$offer->features["max_user_unit"]){
            return false;
        }
        $unit = $offer->features["max_user_unit"];
        $max_limit = $offer->features["max_user_time"] ?? 0;
        $res = pending_reservations_at($offer_id, $unit, $branch);
        //dd($res);
        if ($res->isEmpty()) {
            return true;
        }
        //$res->count("quantity");
        $total_quantity = $res->sum("quantity");
        if ($total_quantity >= $max_limit) {
            return 0;
        }
        return $max_limit - $total_quantity;


    }
}

if (!function_exists('get_branches')) {
    function get_branches($offer_id=null)
    {
        if (!$offer_id) {
            return [];
        }

        $offer = Offering::find($offer_id);
        if (!$offer) {
            return [];
        }
        $branches = $offer->features['selected_branches'] ?? [];
        $branchObjects = Branch::whereIn('id', $branches)->get();

        if (empty($branches)) {
            return [];
        }
        return $branchObjects;
    }
}

if (!function_exists("get_coupons")){
    function get_coupons($id) {
        $offer = Offering::find($id);
        if (!$offer) {
            return [];
        }
        $coupons = $offer->features['coupons'] ?? [];
        if (empty($coupons)) {
            return [];
        }
        $validCoupons = [];
        foreach ($coupons as $coupon) {
            if (isset($coupon['code']) && isset($coupon['discount']) && isset($coupon['expires_at'])) {
                $validUntil = Carbon::parse($coupon['expires_at']);
                if ($validUntil->isFuture()) {
                    $validCoupons[] = [
                        'code' => $coupon['code'],
                        'discount' => $coupon['discount'],
                        'expires_at' => $validUntil->toDateString(),
                    ];
                }
            }
        }

        return $validCoupons;
    }
}

// if (!function_exists("L_trans")){
//     function L_trans($text,$to = "en")
//         {
//             $response = Http::post('https://libretranslate.com/translate', [
//                 'q' => "مرحبا",
//                 'source' => 'auto',
//                 'target' => $to,
//                 'format' => 'text',
//             ]);
//             dd($response->status(), $response->body(), $response->json());

        
//             if ($response->successful()) {
//                 dd($response->status(), $response->body());
//                 //return $response->json()['translatedText'];
//             }
        
//             return 'خطأ في الترجمة';
//         }
// }


function translate($text, $source = 'auto', $target = 'fr') {
    try {
        $response = Http::timeout(10)->get("https://lingva.ml/api/v1/{$source}/{$target}/" . urlencode($text));

        if ($response->successful()) {
            $data = $response->json();
            return $data['translation'] ?? 'خطأ في الترجمة';
        } else {
            return 'فشل الاتصال بـ Lingva';
        }
    } catch (\Exception $e) {
        return 'حدث خطأ: ' . $e->getMessage();
    }
}
