<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\User;
use Session;
use Auth;

class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role != "admin")
            return redirect()->route('home');
        $users = User::where('role','manager')->get();
        return view('users.index',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role != "admin")
            return redirect()->route('home');
        $request->validate([
                "role"      => "required",
                "name"      => "required|min:2",
                "email"     => "required|email",
                "password"  => "required|min:2",
            ]);
        $user = new User();
        $user->role = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->active = 1;
        $user->password = Hash::make($request->password);
        $user->save();
        Session::flash('success', 'L\'utilisateur a été ajouté avec succès!');
        return redirect()->route('users.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->role != "admin")
            return redirect()->route('home');
        $request->validate([
                "role"      => "required",
                "name"      => "required|min:2",
                "email"     => "required|email",
            ]);
        $user = User::find($request->user_id);
        $user->role = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password !== null){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        Session::flash('success', 'L\'utilisateur a été modifié avec succès!');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role != "admin")
            return redirect()->route('home');

        $user = User::find($id);
        if($user->delete())
            Session::flash('success', 'L\'utilisateur a été supprimé avec succès!');
        else
            Session::flash('error', 'Erreur de supprission. Ressayer!');

        return redirect()->route('users.index');
    }

    public function getUser(Request $request)
    {
        if(Auth::user()->role != 'admin')
            return Response::json('Error!');
        $user = User::find($request->id);
        return Response::json($user);
    }

    public function userActiver($id)
    {
        if(Auth::user()->role != 'admin')
            return redirect()->route('home');
        
        $user = User::find($id);
        if($user->active === 1){
            $user->active = 0;
        }elseif($user->active === 0){
            $user->active = 1;
        }
        $user->save();
        return redirect()->route('users.index');
    }
}
