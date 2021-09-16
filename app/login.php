<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class login extends Authenticatable
{
    use Notifiable;

    protected $table = "user";

    protected $fillable = [
        'username','password'
    ];
/*     protected $hidden = [
        'password', 'remember_token',
    ]; */

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;

}