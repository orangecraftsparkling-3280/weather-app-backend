<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // ★ latitude と longitude を追加
    protected $fillable = [
        'city_name',
        'country_code',
        'latitude',
        'longitude'
    ];
}
