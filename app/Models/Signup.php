<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Extend Authenticatable
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Signup extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'organization',
        'email',
        'password',
        'country',
        'profession',
        'purpose',
        'phone',
    ];

    // Ensure the password is hidden when serialized
    protected $hidden = [
        'password', 'remember_token',
    ];
}


// <?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Signup extends Model
// {
//     use HasFactory;
//     protected $fillable = [
//         'name',
//         'organization',
//         'email',
//         'password',
//         'country',
//         'profession',
//         'purpose',
//         'phone',
//     ];
// }