<?php

namespace App\Http\Controllers;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;
    use App\Slider;
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use App\Category;
    use App\Item;
    use App\Brand;
    use App\City;
    use Image;
    use App\ItemImage;
    use App\CityImage;
    use App\CategoryItem;
    use App\User;
    use App\Client;
    use App\Offer;
    use Illuminate\Support\Facades\Storage;
    use Carbon\Carbon;
    use App\WorkHours;
    use App\Favourite;

class FavouriteController extends Controller
{
    public function showFavourite(){
        $categories = Category::all();
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        $user = User::find (Auth::user()->id);
        $favourites =Favourite::where('user_id',$user->id)->get();
        $fav = [];
        foreach ($favourites as $favourite){
            $item = Item::where('id',$favourite->item_id)->first();
            array_push($fav,$item);
        }
        $user = null;
        $favourite = [];
         if (Auth::user()){
            $user = User::find (Auth::user()->id);
            foreach($fav as $item) {
                $favourite_item = Favourite::where('item_id',$item->id)->where('user_id',$user->id)->get();
                if(count($favourite_item) > 0) {
                    array_push($favourite,$item->id);
                }
            }
         }
        return view('vendor.favourite-place',compact('fav','user','categories','cities','user','favourite'));
    }
    public function addToFavourites(Request $request){
        $favourite = new Favourite;
        $favourite->user_id = $request->user_id;
        $favourite->item_id = $request->item_id;
        $favourite->save();
    }
    public function deletefromFavourite(Request $request){
        $favourite = Favourite::where('item_id',$request->item_id)->where('user_id',$request->user_id)->first();
        $favourite->delete();
    }
}
