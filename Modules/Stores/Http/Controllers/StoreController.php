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
    private $repository;


    public function __construct(Request $request, StoreRepository $repository)
    {
        $id = decode($request->route()->parameter('id'));
        $this->repository = $repository;
        $this->repository->setStore(Store::findOrFail($id));

    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('stores::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('stores::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('stores::show');
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
}
