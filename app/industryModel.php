<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class industryModel extends Model
{
    protected $table = 'industry';
    protected $primaryKey = 'in_id';
    protected $fillable = ['in_id','in_nameen','in_nameth','in_headen','in_headth','in_detailen','in_detailth','in_coverimg'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
