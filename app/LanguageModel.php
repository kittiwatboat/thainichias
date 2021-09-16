<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LanguageModel extends Model
{
    protected $table = 'tb_language';
    protected $fillable = ['id','name','sort','status','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
