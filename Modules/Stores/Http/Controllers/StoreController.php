<?php

namespace Modules\Stores\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use Modules\Stores\Entities\Store;
use Modules\Stores\Repositories\StoreRepository;


class StoreController extends Controller
{
    protected $repository;


    public function __construct(Request $request, StoreRepository $repository)
    {

        $id = decode($request->route()->parameter('id'));
        $this->repository = $repository;
        $this->repository->setStore(Store::findOrFail($id));
       
        //parent::__construct();

    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('stores::store.index')->with('store',$this->getStore());
    }



    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    
    

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
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }


    protected function getStore(): Store
    {
        return $this->repository->getStore();
    }
}
