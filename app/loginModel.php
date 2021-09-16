<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class loginModel extends Model
{
    protected $table = 'user';
    protected $fillable = ['id','username','password',];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
