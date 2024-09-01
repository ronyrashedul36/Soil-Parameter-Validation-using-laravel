<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpazilaNirdesika extends Model
{
    use HasFactory;
    protected $fillable = [
        'Division',
        'District',
        'Upazila',
        'FilePath',
        'Year',
    ];
    
}
