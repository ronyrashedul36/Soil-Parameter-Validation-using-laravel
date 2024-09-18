<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'admin_name',
        'receiver_id',
        'message',
        'division',
        'district', 
        'upazila',
        'year'
    ];
}
