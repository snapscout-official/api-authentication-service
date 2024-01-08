<?php

namespace App\Models;

use App\Models\Merchant\Philgep;
use Illuminate\Database\Eloquent\Model;
use App\Models\Merchant\MerchantCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_name',
        'location_id',
        'category_id',
        'philgeps_id'
    ];

    protected $touches = ['user'];
    protected $hidden = [
        'merchant_id',
        'location_id',
        'category_id',
        'philgeps_id'
    ];
    protected $table = 'merchants';
    protected $primaryKey = 'merchant_id';
    public $incrementing = false;
    public $timestamps = false;

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'merchant_id', 'id');
    }

    public function location():BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }
    
    public function merchantCategory():BelongsTo
    {
        return $this->belongsTo(MerchantCategory::class, 'category_id');
    }

    public function philgep():BelongsTo
    {
        return $this->belongsTo(Philgep::class, 'philgeps_id');
    }
}
