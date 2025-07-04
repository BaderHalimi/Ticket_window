<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantChat extends Model
{
    use HasFactory;
    protected $fillable = [
        'merchant_id',
        'user_id',
    ];
    public function messages()
    {
        return $this->hasMany(MerchantMessage::class, 'merchant_chat_id');
    }
    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }
}
