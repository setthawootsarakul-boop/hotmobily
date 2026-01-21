<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = [
        'username', 'email', 'password', 'role', 'status'
    ];

    protected $hidden = [
        'password',
    ];
}