<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\City;
use App\Category;

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
    //protected $redirectTo = '/home';
     public function redirectTo()
     {
         if (Auth::user() -> user_type == 'vendor')
         {
            return 'dashboard';
         }
         if (Auth::user()-> user_type == 'users')
         {
             return 'dashboard';
           //  return 'dash-board';
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

    public function showLoginForm() {
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
        return view('auth.login',compact('cities','categories'));
    }
}
