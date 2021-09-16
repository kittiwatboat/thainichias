<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productcatagoryModel extends Model
{
    protected $table = 'product_catagory';
    protected $primaryKey = 'pc_id';
    protected $fillable = ['pc_id','pc_nameth','pc_nameen','pc_detailth','pc_detailen','pc_headen','pc_headth'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
