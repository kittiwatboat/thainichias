<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class slideModel extends Model
{
    protected $table = 'slide';
    protected $primaryKey = 'slide_id';
    protected $fillable = ['slide_id','slide_image'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
