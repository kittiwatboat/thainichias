<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class industryinteractiveModel extends Model
{
    protected $table = 'industry_interactive';
    protected $primaryKey = 'ina_id';
    protected $fillable = ['ina_id','ina_nameen','ina_nameth','ina_detailen','ina_detailth','ina_img'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
