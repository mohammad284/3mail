<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Slider;
use App\Category;
use App\Item;
use App\Brand;
use App\City;
use App\CityImage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index(){

        return view('user.index');
    }

    public function edit()
    {
        if (Auth::user()){
            $user = User::find (Auth::user()->id);
           // dd($user);
            return view('vendor.MyProfile')->withUser($user);
        }
    }



}