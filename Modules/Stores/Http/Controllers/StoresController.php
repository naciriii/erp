<?php

namespace Modules\Stores\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use Modules\Stores\Entities\Store;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $stores = Store::all();

        $data = [
            'stores' => $stores
        ];
        return view('stores::index')->with($data);
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
    public function store(Request $request, Store $newStore)
    {
        $this->validate($request, [
            'name' => 'required',
            'base_url' => 'required|url',
            'api_url' => 'required|url|unique:stores,api_url'
        ]);
        //Ping base url to check reachability
        $responseCode = '';
        try{
        $client = new Client();
         $res = $client->request('GET', $request->base_url,['timeout' => 5]);
         $responseCode = $res->getStatusCode();

        } catch(GuzzleException $e) {
        $responseCode = 404;
        }
        //Ping api url to check reachability
        $responseCode2 = '';
        try {
             $res2 = $client->request('GET', $request->api_url,['timeout' => 5]);
         $responseCode = $res->getStatusCode();
        
        } catch(GuzzleException $e) {
            $responseCode2 = 404;
        }
        //returns errors in case fail to ping api url or base url
        $errors = [];
          if($responseCode === 404) {
            $errors['base_url'] = trans('stores::global.Unreachable',['attr' => trans('stores::global.BaseUrl')]);
          }
          if($responseCode2 === 404) {
            $errors ['api_url'] = trans('stores::global.Unreachable',['attr' => trans('stores::global.ApiUrl')]);
          }

     if(count($errors)) {
        //return with old inputs
        $request->flash();
        return redirect()->back()->withErrors($errors);

     }
       
        $newStore->name = $request->name;
        $newStore->base_url = $request->base_url;
        $newStore->api_url = $request->api_url;
        $newStore->save();

        return redirect()->route('Stores.index')->with([
            'response' =>  [
             trans('stores::global.Store_added'),
             trans('stores::global.Store_added_success',['store' => '<b>'.$newStore->name.'</b>']),
                'info'
            ]]);


    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        dd(decode($id));
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
