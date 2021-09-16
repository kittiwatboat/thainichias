<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class typeuseModel extends Model
{
    protected $table = 'typeuse';
    protected $primaryKey = 'tu_id';
    protected $fillable = ['tu_id','tu_nameen','tu_nameth','in_id'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
