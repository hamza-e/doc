<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Medecin;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/';
    protected function authenticated($request, $user)
    {
        if($user->role == 'patient'){
            if($request->session()->has('medecin') && $request->session()->has('date')){
                $experties = Medecin::find($request->session()->get('medecin'))->experties;
                return redirect('/search')->with('experties',$experties);
            }
            return redirect('/search');
        }else{
            return redirect('/');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
    * Get the needed authorization credentials from the request.
    *
    * @param \Illuminate\Http\Request $request
    * @return array
    */
    protected function credentials(\Illuminate\Http\Request $request)
    {
        $credentials = $request->only($this->username(),'password');
        return array_add($credentials,'active', '1');
    }

}
