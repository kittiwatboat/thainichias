<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class csrimgModel extends Model
{
    protected $table = 'imgcsr';
    protected $primaryKey = 'ic_id';
    protected $fillable = ['ic_id','csr_id','ic_image'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
