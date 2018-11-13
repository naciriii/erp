<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function getProfile()
    {
        return view('profile.index');

    }
    public function postProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:users,email,'.Auth::user()->id,
            'password' => 'confirmed|nullable|min:6'
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->filled('password')) {
         
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('Profile.get')->with(['response' => 
                            [
             trans('global.Profile_updated'),
             trans('global.Profile_updated_success'),
                'info'
            ]]);


    }
}
