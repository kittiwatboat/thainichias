<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class newsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'news_id';
    protected $fillable = ['news_id','news_image','news_nameth','news_nameen','news_detailth','news_detailen','news_type','news_link'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
