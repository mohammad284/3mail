<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Slider;
use App\Category;
use App\Item;
use App\Brand;
use App\City;
use App\CityImage;
use App\CategoryItem;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function dashboard(){
        return view('users.dashboard');
        }
    public function MyProfile(){
        return view('users.myprofile');
    }
    public function update(Request $request)
    {
        $user = User::find (Auth::user()->id);
        $data = [
            'name'         => $request['name'],
            'email'        => $request['email'],
            'user_type'    =>$request['user_type'],
            'phone_number' =>$request['phone_number'],
            'password'     => Hash::make($request['password']),
        ];
        $user->update($data);
        return redirect()->back()->with('message','تم تعديل معلومات الحساب بنجاح');
    }

    public function resetPassword(Request $request){
        
        $data = request()->validate([
            'email' => 'min:2',
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::where('email',$request->email)->first();
        
        $user->password = $request->password;
        $user->save();
        return redirect ('/login')->with('message','تم تعديل كلمة المرور');
    }

}
