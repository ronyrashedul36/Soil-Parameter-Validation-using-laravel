<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoilPhysicalData extends Model
{
    use HasFactory;
    protected $fillable = [
        'division',
        'district',
        'upazila',
        'year',
        'land_type',
        'soil_group',
        'sg_area',
        'texture',
        'consistency',
        'drainage',
        'moisture',
        'recession',
        'relief'
    ];
}
