<?php

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

        $checks = [
            'name'                => isFilled($offer->name),
            'description'         => isFilled($offer->description),
            'location'            => isFilled($offer->location),
            'image'                 => isFilled($offer->image),
            'price'               => ($offer->price && $offer->price > 0),


            'booking_duration'    => isFilled($features['booking_duration'] ?? null),
            'booking_unit'        => isFilled($features['booking_unit'] ?? null),

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
        $txns = $wallet->transactions()->get();
        $offers = $txns->map(function ($txn) {return $txn->item;})->unique('id');
        $offersPercent = $offers->map(function ($offer) use ($txns) {
            $offerTxns = $txns->where('item_id', $offer->id);
            $totalAmount = $offerTxns->sum('amount');
            return [
                'offer' => $offer,
                'total_amount' => $totalAmount,
                'percentage' => $totalAmount / $txns->sum('amount') * 100,
            ];
        });

        return [
            'wallet' => $wallet,
            'txns' => $txns,
            'offers' => $offers,
            'offersPercent' => $offersPercent,
            'all_selles' => $txns->sum('amount'),
            'all_refunds' => $txns->filter(function ($txn) {return $txn->additional_data['type'] === 'pay';})->sum('amount'),
            'all_payments' => $txns->filter(function ($txn) {return $txn->additional_data['type'] === 'refund';})->sum('amount'),

        ];
    }
}