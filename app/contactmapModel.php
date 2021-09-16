<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contactmapModel extends Model
{
    protected $table = 'contactmap';
    protected $primaryKey = 'ctm_id';
    protected $fillable = ['ctm_id','ctm_imgmap','ctm_countryth','ctm_countryen','ctm_companyth','ctm_companyen','ctm_detailth','ctm_detailen','ctm_linkmap'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
