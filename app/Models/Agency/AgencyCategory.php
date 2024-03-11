<?php

namespace App\Models\Agency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'agency_category_name'
    ];
    protected $table = 'agency_category';
    public $timestamps = false;
}
