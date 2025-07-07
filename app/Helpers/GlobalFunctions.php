<?php

use Illuminate\Support\Facades\Auth;
use App\Models\PaysHistory;
use App\Models\page_views;
use App\Models\User;
use App\Models\Offering;
use App\Models\notifications;


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

        return PaysHistory::create([
            'user_id'         => $data['user_id'] ?? Auth::user()->id,
            'item_id'         => $data['item_id'] ?? null,
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

if (!function_exists('hasEssentialFields')) {

    function isFilled($value): bool
    {
        if (is_null($value)) return false;
        if (is_array($value)) return count($value) > 0;
        return trim((string)$value) !== '';
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

            //'services_type'       => isFilled($features['services_type'] ?? null),
            'base_price'          => isFilled($features['base_price'] ?? null),
            'booking_duration'    => isFilled($features['booking_duration'] ?? null),
            'booking_unit'        => isFilled($features['booking_unit'] ?? null),

            'pricing_packages'    => !empty($features['pricing_packages']) &&
                                      isFilled($features['pricing_packages'][0]['label'] ?? null),

            'gallery'             => !empty($features['gallery']) &&
                                      isFilled($features['gallery'][0] ?? null),
        ];

        $allOk = !in_array(false, $checks, true);

        return [
            'status' => $allOk,
            'fields' => $checks
        ];
    }
}
