<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productminorModel extends Model
{
    protected $table = 'product_minor';
    protected $primaryKey = 'pm_id';
    protected $fillable = ['pm_id','pm_nameth','pm_nameen','pm_img','pc_id'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
