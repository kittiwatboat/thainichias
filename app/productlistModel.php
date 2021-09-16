<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productlistModel extends Model
{
    protected $table = 'product_list';
    protected $primaryKey = 'pl_id';
    protected $fillable = ['pl_id','psm_id','tombo_No','pl_nameth','pl_nameen','pl_desen','pl_desth','pl_filleren','pl_fillerth','pl_file'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
