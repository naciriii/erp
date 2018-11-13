<?php

namespace Modules\Authorization\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $permissions = Permission::all();
        $data = [
            'permissions' => $permissions
        ];
        return view('authorization::permissions.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        
       return view('authorization::permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, Permission $newPermission)
    {
       
        $this->validate($request,[
            'name' => 'required|unique:permissions,name,NULL,id,guard_name,'.config('auth.defaults.guard')
        ]);
        $newPermission->name = $request->name;
        $newPermission->guard_name = config('auth.defaults.guard');
        $newPermission->save();
        if($request->has('permissions')) {
        $newPermission->givePermissionTo($request->permissions);
         }

         return redirect()->route('Permissions.show',['id' => encode($newPermission->id)])
                         ->with(['response' => 
                            [
             trans('permissions::global.Permission_added'),
             trans('permissions::global.Permission_added_success',['permission' => '<b>'.$newPermission->name.'</b>']),
                'info'
            ]]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $id = decode($id);
        $permission = Permission::findOrFail($id);
        $data = [
            'permission' => $permission
        ];

        return view('authorization::permissions.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $id = decode($id);
        $permission = Permission::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|unique:permissions,name,'.$id.',id,guard_name,'.config('auth.defaults.guard')
        ]);
        $permission->name = $request->name;

        $permission->save();

        return redirect()->back()->with(['response' =>
          [
             trans('authorization::global.Permission_updated'),
             trans('authorization::global.Permission_updated_success',
                ['permission' => '<b>'.$permission->name.'</b>']),
                'info'
            ]]);


    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $id = decode($id);
        $permission = Permission::findOrfail($id);
        $permission->delete();
        return redirect()->back()->with(['response' =>
          [
             trans('authorization::global.Permission_deleted'),
             trans('authorization::global.Permission_deleted_success',
                ['permission' => '<b>'.$permission->name.'</b>']),
                'info'
            ]]);
    }
}
