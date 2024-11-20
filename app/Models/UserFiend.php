<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserFiend extends Authenticatable
{
    use HasFactory;
    use HasFactory;

    protected $table = 'users_fiend';

    protected $fillable = [
        'name',
        'contact_number',
        'password',
        'user_type'
    ];

    protected $hidden = [
        'password',
    ];

}
