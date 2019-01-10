<?php

namespace Modules\Stores\Repositories;


use Modules\Stores\Repositories\Contracts\BaseRepository as BaseRepositoryI;
use Modules\Stores\Entities\Provider;
use Cache;

class ProviderRepository extends BaseRepository implements BaseRepositoryI
{

    public function all($params = null)
    {
        $providers = $this->getStore()->providers;

        return $providers;
        
    }

    public function find($cat)
    {

    }

    public function add($category)
    {
       
        
    }

    public function update($category, $cat)
    {
        
    }

    public function delete($cat)
    {
        
    }





}