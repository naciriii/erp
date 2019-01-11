<?php

namespace Modules\Stores\Repositories;


use Modules\Stores\Repositories\Contracts\BaseRepository as BaseRepositoryI;
use Modules\Stores\Entities\Provider;
use Modules\Stores\Entities\ProviderAddress;
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

    public function add($providerBean)
    {
         $providerModel = new Provider;
   
        $providerModel->name = $providerBean->name;
        $providerModel->slug = $providerBean->slug;
        $providerModel->is_active = true;
        $providerModel->store_id = $this->getStore()->id;
        $providerModel->save();
    
        $providerId = $providerModel->id;

        $providerBean->addresses = collect(json_decode($providerBean->addresses,true));
        //dd($providerBean->addresses);
        $providerBean->addresses->transform(function($item,$key) use($providerId) {
            $item['provider_id'] = $providerId;
            $item['city'] = (trim($item['city']) !="") ? trim($item['city']) : "_";
            $item['street'] = (trim($item['street']) !="") ? trim($item['street']) : "_";
           
            return $item;
        });

        /*
        ProviderAddress::create($providerBean->addresses->toArray());
        */
      
        foreach($providerBean->addresses as $a) {
            $pa = new ProviderAddress;
            $pa->is_primary = $a['is_primary'];
            $pa->city = $a['city'];
            $pa->street = $a['street'];
            $pa->provider_id = $a['provider_id'];
            $pa->lat = $a['lat'];
            $pa->lng = $a['lng'];
            $pa->address = $a['address'];
            $pa->save();



        }
    
        dd($providerModel->load('addresses'));



      
        
    }

    public function update($category, $cat)
    {
        
    }

    public function delete($cat)
    {
        
    }





}