<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class csrModel extends Model
{
    protected $table = 'csr';
    protected $primaryKey = 'csr_id';
    protected $fillable = ['csr_id','csr_nameen','csr_nameth','csr_coverimg','csr_detailen','csr_detailth','csr_type'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
