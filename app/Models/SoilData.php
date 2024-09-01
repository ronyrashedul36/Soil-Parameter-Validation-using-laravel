<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoilData extends Model
{
    use HasFactory;

    protected $fillable = [
        'division',
        'district',
        'upazila',
        'fid',
        'smpl_no',
        'mu',
        'land_type',
        'soil_series',
        'soil_group',
        'texture',
        'ec',
        'ph',
        'ea',
        'om',
        'n',
        'po',
        'pb',
        'k',
        's',
        'zn',
        'b',
        'ca',
        'mg',
        'cu',
        'fe',
        'mn',
        'upz_code',
        'year',
    ];
}
