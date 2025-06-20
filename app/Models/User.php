<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Merchant\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'f_name',
        'l_name',
        'email',
        'business_name',
        'business_type',
        'email_verified_at',
        'password',
        'role',
        'phone',
        'additional_data',
        'is_accepted',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'additional_data' => 'array',
    ];
    /**
     * Get the events created by the user.
     */


    // public function getAdditionalDataAttribute($value)
    // {
    //     return json_decode($value, true);
    // }
    public function branches(){
        return $this->hasMany(Branch::class,'user_id','id');
    }
    public function offers(){
        return $this->hasMany(Offering::class,'user_id');
    }
}
