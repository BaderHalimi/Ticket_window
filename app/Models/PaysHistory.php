<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaysHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'item_id',
        'amount',
        'transaction_id',
        'status',
        'payment_method',
        'additional_data',
    ];
    protected $casts = [
        'additional_data' => 'array',
    ];
    public function item()
    {
        return $this->belongsTo(Offering::class);
    }


}
