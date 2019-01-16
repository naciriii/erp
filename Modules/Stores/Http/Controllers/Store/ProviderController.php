<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;
use Request as Req;
use Carbon\Carbon;

class ProviderController extends StoreController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $search = Req::input('search');
        $providers = $this->repository->all(['search' => $search]);

        $data = [
            'result' => $providers,
            'store' => $this->getStore(),
            'findby' => $search
        ];

        return view('stores::store.providers.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = ['store' => $this->getStore()];
        return view('stores::store.providers.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
            'addresses' => 'required|json']);
          $this->repository->add((object)$request->all());

          return redirect()->route('Store.Providers.index', ['id' => $id])
            ->with(['response' => [
                trans('stores::global.Provider_added'),
                trans('stores::global.Provider_added_success', ['provider' => '<b>' . $request->name . '</b>']),
                'info'
            ]]);
        
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id, $provider_id)
    {
          $provider = $this->repository->find(decode($provider_id));
        if ($provider == null) {
            return abort(404);
        }
        $data = [
            'provider' => $provider,
            'store' => $this->getStore()
        ];
        return view('stores::store.providers.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('stores::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id, $provider, Request $request)
    {
        
         $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
            'addresses' => 'required|json']);

         $this->repository->update((object)$request->all(), decode($provider));

         return redirect()->route('Store.Providers.index', ['id' => $id])
            ->with(['response' => [
                trans('stores::global.Provider_updated'),
                trans('stores::global.Provider_updated_success', ['provider' => '<b>' . $request->name . '</b>']),
                'info'
            ]]);

    }



    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete($id, $provider_id)
    {
        $p = $this->repository->delete(decode($provider_id));
         return redirect()->route('Store.Providers.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Provider_deleted'),
                trans('stores::global.Provider_deleted_success', ['provider' => '<b>' .$p->name  . '</b>']),
                'info'
            ]]);
    }
}
