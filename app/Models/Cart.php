<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'item_type',
        'user_id',
        'quantity',
        'price',
        'discount',
        'additional_data',
    ];
    public function items (){
        return $this->morphTo();
    }
}
