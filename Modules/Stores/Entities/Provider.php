<?php

namespace Modules\Stores\Entities;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [];

    public function addresses()
    {
    	return $this->hasMany(ProviderAddress::class);
    }
}
