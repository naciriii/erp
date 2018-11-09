<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use Auth;
use App\User;





class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();

        $data = [
            'users' => $users
        ];
        return view('users::index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

        return view('users::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, User $newUser)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:users',
            'password' => 'required|confirmed'
        ]);
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = bcrypt($request->password);
        $newUser->save();
        return redirect()->route('Users.show',['id' => encode($newUser->id)])
                         ->with(['response' => 
                            [
             trans('users::global.Added'),
             trans('users::global.Added_success',['user' => '<b>'.$newUser->name.'</b>']),
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
        $user = User::findOrFail($id);
        $data = [
            'user' => $user
        ];
        return view('users::show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {

        return view('users::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
         $id = decode($id);
         $user = User::findOrFail($id); 
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'password' => 'confirmed'

        ]);
     
         $user->name = $request->name;
         $user->email = $request->email;
         if($request->has('password')) {
            $user->password = bcrypt($request->password);
         }
         $user->save();
         return redirect()->back()->with(['response' =>
          [
             trans('users::global.Updated'),
             trans('users::global.Updated_success',['user' => '<b>'.$user->name.'</b>']),
                'info'
            ]
      ]);

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $id = decode($id);
        $user = User::findOrFail($id);
        $user->delete();

         return redirect()->back()->with(['response' =>
          [
             trans('users::global.Deleted'),
             trans('users::global.Deleted_success',['user' => '<b>'.$user->name.'</b>']),
                'info'
            ]]);

    }
}
