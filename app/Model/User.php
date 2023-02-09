<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql';

    protected $fillable = [
        'email',
        'nama',
        'password',
        'token',
        'status',
        'photo'
    ];

    protected $hidden = [
        'password'
    ];
}
