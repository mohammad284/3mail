<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App;
use App\About;
use App\Category;
use App\Item;
use App\City;
use Session;
 

class AboutController extends Controller
{
    
    public function index(){
        $about = About::all()->first();
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
        return view('front_views.about',compact('about','categories','cities'));
    }
    public function about_en(){
        
        $about = About::all()->first();
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
        return view('front_views.about',compact('about','categories','cities'));
    }
    
    public function about_ar(){
       
        $about = About::all()->first();
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
        return view('front_views.about',compact('about','categories','cities'));
    }
    
    // privacy policy
    public function privacy_en(){
        Session::put('locale','en');
        App::setLocale('en');
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
        return view('front_views.privacy_en',compact('categories','cities'));
    }
    
    public function privacy_ar(){
        Session::put('locale','ar');
        App::setLocale('ar');
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
        return view('front_views.privacy_ar',compact('categories','cities'));
    }
    
    // conditions
    public function conditions_en(){
        Session::put('locale','en');
        App::setLocale('en');
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
        return view('front_views.conditions_en',compact('categories','cities'));
    }
    
    public function conditions_ar(){
        Session::put('locale','ar');
        App::setLocale('ar');
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
        return view('front_views.conditions_ar',compact('categories','cities'));
    }

    
}
