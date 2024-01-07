<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_name'
    ];
    public const MERCHANT = 1;
    public const AGENCY = 2;
    publiC const ADMIN = 3;
    public $timestamps = false;

}
