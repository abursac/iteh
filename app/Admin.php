<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Admin extends User
{
    protected $fillable = [
        'email'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
