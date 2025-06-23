<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaysHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'transaction_id',
        'status',
        'payment_method',
        'additional_data',
    ];
    public function item()
    {
        return $this->belongsTo(Offering::class);
    }

}
