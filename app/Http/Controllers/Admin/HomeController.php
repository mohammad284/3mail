<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Item;
use App\City;
use App\Category;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities       = City::all();
        $items        = Item::all();
        $item         = Item::where('item_states','0')->get();
        $categories   = Category::all();
        $users        = User::where('user_type','users')->get();
        $vendor       = User::where('vendor_request','1')->get();
        $items_count  = count($items);
        $city_count   = count($cities);
        $cat_count    = count($categories);
        $user_count   = count($users); 
        $item_count   = count ($item);
        $vendor_count = count($vendor);
        return view('dashboard.index',compact('items_count','city_count','cat_count','user_count','item_count','vendor_count'));
    }

    public function allUsers(){
        $users = User::where('type',0)->where('vendor_request', 0)->orderBy('id','DESC')->paginate(15);
        return view('dashboard.all-users',compact('users'));
    }
}