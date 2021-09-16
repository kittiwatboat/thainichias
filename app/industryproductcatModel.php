<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class industryproductcatModel extends Model
{
    protected $table = 'industry_productcat';
    protected $primaryKey = 'inpc_id';
    protected $fillable = ['inpc_id','in_id','inpt_id','in_headen','pm_id'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
