<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\ItemImage;
use App\City;
use App\Category;
use App\CategoryItem;
use App\User;
use App\Favourite;

class ItemController extends Controller
{
   
    public function index(){
        $items = Item::orderBy('id','DESC')->paginate(16);
        $categories = Category::all();
        return view('front_views.products',compact('items','categories'));
    }

    public function item($id) {
        $category = Category::find($id);
        $items = $category->items;
        $categories = Category::orderBy('id','ASC')->take(5)->get();
        $last_products = Item::orderBy('id','ASC')->take(5)->get();
        return view('front_views.products-cat',compact('items','categories','category','last_products'));
    }

    public function single($id) {
        $pro = Item::where('id',$id)->first();
        $items = Item::orderBy('id','DESC')->take(10)->get();
        $categories = Category::all();
        return view('front_views.single-product',compact('pro','items','categories'));
    }

    public function categoryCity($cat_id,$city_id) {
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $this_city = City::where('id',$city_id)->first();
        $categories = Category::all();
        $items = Category::find($cat_id)->items()->where('city_id',$city_id)->orderBy('id','DESC')->where('item_states',1)->paginate(16);
        $category = Category::where('id',$cat_id)->first();
        $user = null;
        $favourite = [];
         if (Auth::user()){
            $user = User::find (Auth::user()->id);
            foreach($items as $item) {
                $favourite_item = Favourite::where('item_id',$item->id)->where('user_id',$user->id)->get();
                if(count($favourite_item) > 0) {
                    array_push($favourite,$item->id);
                }
            }
         }
        return view('front_views.category-city',compact('cities','categories','category','items','this_city','user','favourite'));
    }

  
}
