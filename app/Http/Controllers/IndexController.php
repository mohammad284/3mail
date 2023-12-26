<?php

namespace App\Http\Controllers;
   use Illuminate\Support\Facades\Storage;
   use Illuminate\Http\Request;
   use App\Slider;
   use App\Category;
   use App\Item;
   use App\Brand;
   use App\City;
   use App\CityImage;
   use App\CategoryItem;
   use App\GoogleMaps;
   use Mail;
   use App\User;
   use Illuminate\Support\Facades\Auth;
   use App\QRCoode;
   use Image;
   use File;
   use App\Client;
   use App\WorkTime;
   use App\Favourite;


class IndexController extends Controller {
    
   public function index() {
        $slides = Slider::all();
        $cities = City::orderBy('id','ASC')->take(6)->get();
        $categories_item = Category::orderBy('id','ASC')->take(10)->get();
        $items = Item::orderBy('id','DESC')->where('item_states','1')->take(16)->get();
        $categories = Category::all();
        $new_items = Item::orderBy('created_at','DESC')->take(8)->get();
        $top_rates = Item::orderBy('rating', 'DESC')->where('item_states','1')->take(10)->get();
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
        return view('front_views.index',compact('slides','categories','items','categories_item','new_items','cities','top_rates','favourite','user'));
   }

   public function category($id) {
      $cities = City::orderBy('id','DESC')->take(6)->get();
      $categories = Category::all();
      $category = Category::where('id',$id)->first();
      $items = Category::find($id)->items()->where('item_states',1)->orderBy('id','DESC')->paginate(16);
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
      return view('front_views.category',compact('cities','categories','category','items','user','favourite'));
   }
   
   public function contact() {
      $categories = Category::all();
      $cities = City::orderBy('id','DESC')->take(6)->get();
      return view('front_views.contact',compact('categories','cities'));

   }
   
    // send email
   public function sendContact(Request $request) {
             $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'phone' => 'required',
            'message' => 'required',
       ]);
      $data = array('name'=> $request->name, 'email' => $request->email, 'subject' => $request->subject,'phone' => $request->phone, 'message_txt' =>$request->message );
      Mail::send('front_views.mail', $data, function($message) use ($data) {
         $message->to('hussenmohammad915@gmail.com', 'Message from website')->subject
            ($data['subject']);
         $message->from($data['email'], $data['name']);
      });
      
      return redirect()->back()->with('message','تم إرسال الرسالة بنجاح');  
   }
   ################ cities ###############
   public function All_cities(){
      $cities = City::orderBy('id','DESC')->take(6)->get();
      $cities_all = City::orderBy('id','DESC')->paginate(15);
      $categories = Category::all();
      return view('front_views.all_cities',compact('cities','cities_all','categories'));
   }
   
   public function city_front($id){
      $cities = City::orderBy('id','DESC')->take(6)->get();
      $city = City::where('id',$id)->first();
      $categories = Category::all();
      return view('front_views.city',compact('city','categories','cities'));
   }

   public function Place_Details($id){
      $user = null;
      $favourite = [];
      if (Auth::user()){
         $user = User::find (Auth::user()->id);
         $favourite = Favourite::where('item_id',$id)->where('user_id',$user->id)->get();
      }
      $categories = Category::all();
      $cities = City::orderBy('id','DESC')->take(6)->get();
      $workTime = WorkTime::where('item_id',$id)->get();
      $item = Item::where('id',$id)->first();
      $city = City::where('id',$item->city_id)->first();
      $clients = Client::where('item_id',$id)->get();
      $res =[];
      $item_cat = Item::find($id)->categories()->get();
      foreach($clients as $client){
         $user = User::where('id',$client->user_id)->first();
         $final = array('review'=>$client,'user'=>$user);
         array_push($res,$final);
      }
      $item_whatsapp = '';
      if ($item->whatsapp_phone != null) {
         $item_whatsapp = str_replace("+","",$item->whatsapp_phone);
      }
      return view('front_views.Place_Details',compact('favourite','item','city','cities','categories','workTime','res','clients','item_cat','item_whatsapp','user'));
   }
   public function icon(){
       $categories = Category::all();
       $cat = [];
       foreach($categories as $category){
           $items = CategoryItem::where('category_id',$category->id)->get();
           $final = array('category'=>$category, 'items'=>$items);
           array_push($cat,$final);
       }
       
       dd($cat);
       
   }
   //search
   public function search(){
         $categories = Category::all();
         $cities = City::orderBy('id','DESC')->take(6)->get();
         $search_text = $_GET ['search'];
         $search_item = [];
         $result_city = City::whereTranslationLike ('name','%'.$search_text.'%')->get();
            if(count($result_city) > 0){
               $items_city = new Item;
                  foreach ($result_city as $city){
                        $items_city = Item::where('city_id',$city->id)->get();
                  }
                  foreach ($items_city as $item) {
                     array_push($search_item,$item);
                  }
            }
         $result_cat = Category::whereTranslationLike('name','%'.$search_text.'%')->get();
            if(count($result_cat) > 0){
               $items_cat = new CategoryItem;
               $items = new Item;
                  foreach ($result_cat as $category){
                     $items_cat = CategoryItem::where('category_id',$category->id)->get();
                  }
                  foreach ($items_cat as $item_cat) {
                     $items = Item::where('id',$item_cat->item_id)->get();
                  }
                  foreach ($items as $item) {
                     array_push($search_item,$item);
                  }
            }
      
         $result_item = Item::whereTranslationLike ('name','%'.$search_text.'%')->get();
            if(count($result_item) > 0){
               foreach ($result_item as $item){
                  array_push($search_item,$item);
               }
            }

      return view('front_views.result',compact('search_item','categories','cities'));

   }
}