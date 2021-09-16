<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productsubminorModel extends Model
{
    protected $table = 'product_subminor';
    protected $primaryKey = 'psm_id';
    protected $fillable = ['psm_id','pm_id','psm_nameth','psm_nameen','psm_detailth','psm_detailen','psm_img','psm_link'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
