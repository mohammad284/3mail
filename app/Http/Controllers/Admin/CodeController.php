<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\CodeUser;
use Validator;
class CodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function showAddCode(){
        return view('dashboard.code.add-code');
    }
    public function makeCode(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'code'  => ['required', 'unique:code_users'],
        ]);

        $user = User::where('email',$request->email)->first();
        if($user == null){
            return redirect()->back()->with('message','ادخل ايميل صالح');
        }else{
            $user->code = $request->code;
            $user->save();
        }
        return redirect()->back()->with('message','تم حفظ الكود');
    }
    public function userCodes(){
        $users = User::all();
        $code_details = [];
        foreach($users as $user){
            if($user->code != null){
                array_push($code_details , $user);
            }
        }
        $count = count($code_details);
        return view('dashboard.code.index-code',compact('code_details','count'));
    }
    public function destroy($user_id){
        $user_code = User::where('id',$user_id)->first();
        $user_code->code = null;
        $user_code->save();
        return redirect()->back()->with('message','تم الحذف بنجاح');
    }
}