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
        $providers = $this->getStore()->providers()->paginate(20);

        return $providers;
        
    }

    public function find($provider_id)
    {

        return Provider::find($provider_id);

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
            $item['created_at'] = date('Y-m-d H:i:s');
            $item['updated_at'] = date('Y-m-d H:i:s');
           
            return $item;
        });

        
        ProviderAddress::insert($providerBean->addresses->toArray());

     
        



      
        
    }

    public function update($providerBean, $provider_id)
    {
        $providerModel = Provider::find($provider_id);
   
        $providerModel->name = $providerBean->name;
        $providerModel->slug = $providerBean->slug;
        $providerModel->is_active = true;
        $providerModel->save();
    
        $providerId = $providerModel->id;

        $providerBean->addresses = collect(json_decode($providerBean->addresses,true));
        //dd($providerBean->addresses);
        $providerBean->addresses->transform(function($item,$key) use($providerId) {
            $item['provider_id'] = $providerId;
            $item['city'] = (trim($item['city']) !="") ? trim($item['city']) : "_";
            $item['street'] = (trim($item['street']) !="") ? trim($item['street']) : "_";
            $item['created_at'] = date('Y-m-d H:i:s');
            $item['updated_at'] = date('Y-m-d H:i:s');
           
            return $item;
        });
        ProviderAddress::where('provider_id',$providerId)->delete();

        
        ProviderAddress::insert($providerBean->addresses->toArray());

        
    }

    public function delete($provider_id)
    {
         $providerModel = Provider::find($provider_id);
         ProviderAddress::where('provider_id',$provider_id)->delete();
         $providerModel->delete();
         return $providerModel;

        
    }





}