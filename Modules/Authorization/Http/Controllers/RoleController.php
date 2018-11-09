<?php

namespace Modules\Authorization\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use Role;
use Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $roles = Role::where('guard_name',config('auth.defaults.guard'))->get();
        $data = [
            'roles' => $roles
        ];
        return view('authorization::roles.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $permission = Permission::where('guard_name',config('auth.defaults.guard'))->get();
        $data = [
            'permissions' => $permission
        ];
       return view('authorization::roles.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, Role $newRole)
    {
       
        $this->validate($request,[
            'name' => 'required|unique:roles,name,NULL,id,guard_name,'.config('auth.defaults.guard'),
            'permissions.*' => 'integer'
        ]);
        $newRole->name = $request->name;
        $newRole->guard_name = config('auth.defaults.guard');
        $newRole->save();
        if($request->has('permissions')) {
        $newRole->givePermissionTo($request->permissions);
         }

         return redirect()->route('Roles.show',['id' => encode($newRole->id)])
                         ->with(['response' => 
                            [
             trans('roles::global.Role_added'),
             trans('roles::global.Role_added_success',['role' => '<b>'.$newRole->name.'</b>']),
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
        $role = Role::findOrFail($id);
        $permissions = Permission::where('guard_name',config('auth.defaults.guard'))->get();
        $data = [
            'role' => $role,
            'permissions' => $permissions
        ];

        return view('authorization::roles.show')->with($data);
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
        $role = Role::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|unique:roles,name,'.$id.',id,guard_name,'.config('auth.defaults.guard'),
            'permissions.*' => 'integer'
        ]);
        $role->name = $request->name;
        $role->syncPermissions($request->permissions);
        $role->save();

        return redirect()->back()->with(['response' =>
          [
             trans('authorization::global.Role_updated'),
             trans('authorization::global.Role_updated_success',
                ['role' => '<b>'.$role->name.'</b>']),
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
        $role = Role::findOrfail($id);
        $role->delete();
        return redirect()->back()->with(['response' =>
          [
             trans('authorization::global.Role_deleted'),
             trans('authorization::global.Role_deleted_success',
                ['role' => '<b>'.$role->name.'</b>']),
                'info'
            ]]);
    }
}
