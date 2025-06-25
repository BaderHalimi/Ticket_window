<?php

use Illuminate\Support\Facades\Auth;
use App\Models\PaysHistory;

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

