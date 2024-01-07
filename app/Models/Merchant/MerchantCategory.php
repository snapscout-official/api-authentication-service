<?php

namespace App\Models\Merchant;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerchantCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'merchant_name'
    ];
    
    protected $table = 'merchant_category';
    public $timestamps = false;

    public function merchant():HasOne
    {
        return $this->hasOne(Merchant::class, 'category_id');
    }
}
