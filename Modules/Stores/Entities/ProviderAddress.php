<?php

namespace Modules\Stores\Entities;

use Illuminate\Database\Eloquent\Model;

class ProviderAddress extends Model
{
    protected $fillable = array("is_primary","city","street","lat","lng","address","provider_id");
}
