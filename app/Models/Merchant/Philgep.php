<?php

namespace App\Models\Merchant;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Philgep extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_path'
    ];

    protected $table = 'philgeps';
    public $timestamps = false;

    public function merchant(): HasOne
    {
        return $this->hasOne(Merchant::class, 'philgeps_id');
    }
}
