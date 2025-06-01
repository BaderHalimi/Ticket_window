<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'name',
        'location',
        'tables',
        'hour_price',
        'open_at',
        'close_at',
        'status',
        'restaurent_id',
        'gallery'
    ];
    protected $casts = [
    'gallery' => 'array',
    ];
    
   
}
