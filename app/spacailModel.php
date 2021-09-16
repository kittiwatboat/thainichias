<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spacailModel extends Model
{
    protected $table = 'spacailfocus';
    protected $primaryKey = 'sf_id';
    protected $fillable = ['sf_id','sf_nameen','sf_nameth','sf_detailen','sf_detailth','sf_img','tp_id'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
