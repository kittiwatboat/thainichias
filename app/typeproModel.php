<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class typeproModel extends Model
{
    protected $table = 'industry_producttype';
    protected $primaryKey = 'inpt_id';
    protected $fillable = ['inpt_id','in_id','inpt_nameen','inpt_nameth','tu_id','inpt_detailen','inpt_detailth','inpt_link','inpt_img'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
