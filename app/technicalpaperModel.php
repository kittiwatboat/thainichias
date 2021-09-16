<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class technicalpaperModel extends Model
{
    protected $table = 'technicalpaper';
    protected $primaryKey = 'tp_id';
    protected $fillable = ['tp_id','tp_paper','tp_nameen','tp_nameth','tp_type','tp_paperimg'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
