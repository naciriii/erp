<?php

namespace Modules\Stores\Entities;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [];

    public function providers()
    {
    	return $this->hasMany('Modules\Stores\Entities\Provider','store_id','id');
    }
}
