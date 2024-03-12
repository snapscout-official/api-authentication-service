<?php

namespace App\Models;

use App\JWT_traits\HasClaims;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Facades\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasClaims;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'tin_number',
        'gender',
        'phone_number',
        'email',
        'password',
        'role_id'
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
    ];
   
    public function isMerchant():bool{
        if ($this->role_id === Role::MERCHANT){
            return true;
        }
        return false;
    }
    public function agency():HasOne{
        return $this->hasOne(Agency::class, 'agency_id', 'id');
    }
    public function merchant():HasOne{
        return $this->hasOne(Merchant::class, 'merchant_id', 'id');
    }
    public function generateToken(){
        return JWTAuth::fromUser($this);
    }
}
