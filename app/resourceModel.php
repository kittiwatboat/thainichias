<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class resourceModel extends Model
{
    protected $table = 'resource';
    protected $primaryKey = 're_id';
    protected $fillable = ['re_id','re_nameen','re_nameth','re_detailen','re_detailth','re_coverimg','re_img'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
