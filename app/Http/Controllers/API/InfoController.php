<?php
namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Password;
    use Illuminate\Support\Facades\Storage;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use App\City;
    use App\Category;
    use App\Item;
    use App\User;
    use App\CategoryItem;
    use App\ItemImage;
    use App\Complaint;
    use App\ItemCode;
    use App\ComplaintImage;
    use App\Client;
    use Illuminate\Support\Facades\Http;
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Image;
    use App\Offer;
    use App\Event;
    use Carbon\Carbon;
    use App\WorkTime;
    use App\AnimatedTicker;
    use App\Favourite;
    use App\Notification;
    use App\OfferUser;
    use App\Reservation;
    use App\Question;
    use Illuminate\Support\Facades\Mail;
    use App\Mail\MailNotify;
    use App\GeneralPage;
    use App\GeneralPageTranslation;
    use App\AppImage;
    use App\Visit;
    use DateTime;
class InfoController extends Controller
{

    // Get All Cities
    public function cities(Request $request){
        if($request->fcm_token !=null){
        $users_token = User::where('fcm_token',$request->fcm_token)->get();
        foreach($users_token as $user_token){
        $user_token->fcm_token = '0';
        $user_token->save();
        }
        $user = User::where('id',$request->user_id)->first();
        $user->fcm_token = $request->fcm_token;
        $user->save();
        $cities = City::all();
        return response()->json([
            'cities'=>$cities,
            'user'=> $user,
            'key' =>'AIzaSyAufMZJuYiLNoAm2-nO7wP_E-sfk5AlGPo',
        ]);
        }else{
        $cities = City::all();
        return response()->json([
            'cities'=>$cities,
            'key' =>'AIzaSyAufMZJuYiLNoAm2-nO7wP_E-sfk5AlGPo',
             ]);
        }
    }

    // get city by id
    public function cityid($id){
        $items = Item::where('city_id',$id)->get();
        $items_array = [];
        foreach ($items as $item) {
            $itemimage=ItemImage::where('item_id',$item->id)->get();
            $final_item = array('place_data'=>$item,'place_image'=>$itemimage);
            array_push($items_array,$final_item);
        }
         return response()->json($items_array);
    }
        
    public function items(){
        $items = Item::where('item_states','1')->get();
        $items_array = [];
        foreach ($items as $item) {
            $itemimage=ItemImage::where('item_id',$item->id)->get();
            $worktimes   = WorkTime::where('item_id',$item->id)->get();
            $final_item = array('place_data'=>$item,'place_image'=>$itemimage , 'worktime'=>$worktimes);
            array_push($items_array,$final_item);
        }
        return response()->json($items_array);
    }
    
    // Get All Categories
    public function categories(){
        $categories = Category::all();
          return response()->json($categories);
        }
        // get category by city id
        public function categoryId($id){
           $city=City::where('id',$id)->first();
           $category=$city->categories;
            return response()->json($category);
    }

    //get item by city and categort id
    public function itemId($id,$cat_id){
        $item_cat = CategoryItem::where('category_id',$cat_id)->get();
        $item_city =Item::where('city_id',$id)->where('item_states','1')->get();
        $items_array = [];
        foreach ($item_cat as $itemcat) {
            foreach ($item_city as $itemcity) {
                if ($itemcat->item_id == $itemcity->id ) {
                    $item       = Item::where('id',$itemcity->id)->first();
                    $itemimage  = ItemImage::where('item_id',$item->id)->get();
                    $worktimes  = WorkTime::where('item_id',$item->id)->get();
                    $categories = CategoryItem::where('item_id',$item->id)->get();
                    $categories_item =[];
                    foreach($categories as $category){
                    $category_item = Category::where('id',$category->category_id)->first();
                    array_push($categories_item,$category_item);
                    }
                    $final_item = array('place_data'=>$item,'place_image'=>$itemimage , 'worktime'=>$worktimes,'category'=>$categories_item);
                    array_push($items_array,$final_item);
                }
            }
        }
        return response()->json($items_array);
    }

    //make search
    public function search($name){
        
        $cities = City::all();
        $search_item = [];
        $temp_array = [];

        $result_city = City::whereTranslationLike ('name','%'.$name.'%')->get();
        if(count($result_city) > 0){
            $items_city = new Item;
            foreach ($result_city as $city){
                    $items_city = Item::where('city_id',$city->id)->where('item_states','1')->get();
            }
            foreach ($items_city as $item) {
                $itemimage = ItemImage::where('item_id',$item->id)->get();
                $worktimes = WorkTime::where('item_id',$item->id)->get();
                $categories = CategoryItem::where('item_id',$item->id)->get();
                $categories_item =[];
                foreach($categories as $category){
                $category_item = Category::where('id',$category->category_id)->first();
                array_push($categories_item,$category_item);
                }
                $final_item = array('place_data'=>$item,'place_image'=>$itemimage , 'worktime'=>$worktimes,'category'=>$categories_item);
                array_push($search_item,$final_item);
            }
        }
        
        $result_cat = Category::whereTranslationLike('name','%'.$name.'%')->get();
        if(count($result_cat) > 0){
            $items_cat = new CategoryItem;
            $items = new Item;
            foreach ($result_cat as $category){
                $items_cat = CategoryItem::where('category_id',$category->id)->get();
            }
            foreach ($items_cat as $item_cat) {
                $items = Item::where('id',$item_cat->item_id)->where('item_states','1')->get();
            }
            foreach ($items as $item) {
                $itemimage = ItemImage::where('item_id',$item->id)->get();
                $worktimes   = WorkTime::where('item_id',$item->id)->get();
                $categories = CategoryItem::where('item_id',$item->id)->get();
                $categories_item =[];
                foreach($categories as $category){
                $category_item = Category::where('id',$category->category_id)->first();
                array_push($categories_item,$category_item);
                }
                $final_item = array('place_data'=>$item,'place_image'=>$itemimage , 'worktime'=>$worktimes,'category'=>$categories_item);
                array_push($search_item,$final_item);
            }
        }
       
        $result_item = Item::whereTranslationLike ('name','%'.$name.'%')->where('item_states','1')->get();
        if(count($result_item) > 0){
            
            foreach ($result_item as $item){
                $itemimage = ItemImage::where('item_id',$item->id)->get();
                $worktimes   = WorkTime::where('item_id',$item->id)->get();
                $categories = CategoryItem::where('item_id',$item->id)->get();
                $categories_item =[];
                foreach($categories as $category){
                $category_item = Category::where('id',$category->category_id)->first();
                array_push($categories_item,$category_item);
                }
                $final_item = array('place_data'=>$item,'place_image'=>$itemimage , 'worktime'=>$worktimes,'category'=>$categories_item);
                array_push($search_item,$final_item);
            }
        }
    
        return response()->json($search_item);
    }

    //add item from dashboard vendor
    public function addItem(Request $request){
        if($request->user_code != null){
            $code = User::where('code',$request->user_code)->first();
            if($code == null){
                return response()->json('الرجاء ادخال كود صحيح');
            }
        }
       
        $meta_title_ar      =$request->item_title_ar;
        $meta_title_en      =$request->item_title_en;
        $meta_keywards_ar   =$request->item_title_ar;
        $meta_keywards_en   =$request->item_title_en;
        $meta_Discription_ar=$request->item_desc_ar;
        $meta_Discription_en=$request->item_desc_en;
        
        $data = [
            'city_id'              => $request->item_city,
            'phone_number'         => $request->item_phone,
            'longitude'            => $request->longitude,
            'latitude'             => $request->latitude,
            'item_states'          => '0',
            'reservation_phone'    => $request->reservation_phone,
            'whatsapp_phone'       => $request->whatsapp_phone,
            'vendor_id'            => $request->vendor_id,
            'link'                 => $request->link,
            'imaging_type'         => $request->imaging_type,
            'ar' => [
                'name'             => $request->item_title_ar,
                'address'          => $request-> item_address_ar,
                'description'      => $request->item_desc_ar,
                'meta_title'       => $meta_title_ar,
                'meta_keywards'    => $meta_keywards_ar,
                'meta_Discription' => $meta_Discription_ar,
                'food_menu'        => $request -> food_menu_ar,
            ],
            'en' => [
                'name'             => $request->item_title_en,
                'address'          => $request-> item_address_en,
                'description'      => $request->item_desc_en,
                'meta_title'       => $meta_title_en,
                'meta_keywards'    => $meta_keywards_en,
                'meta_Discription' => $meta_Discription_en,
                'food_menu'        => $request -> food_menu_en,
            ]
        ];
        $item = Item::create($data);
        if($request->user_code != null){
            ItemCode::insert( [
                'user_id'=>  $code->id,
                'item_id'=> $item->id,
                'code'   =>$request->user_code
            ]);
        }
        $item_categories = $request->category;
        if(!$item_categories == NULL) {
            foreach($item_categories as $cat) {
                CategoryItem::insert( [
                    'category_id'=>  $cat,
                    'item_id'=> $item->id
                ]);
            }
        } 
        $image = \QrCode::format('png')
        ->size(200)->errorCorrection('H')
        ->generate($item->id);
        $output_file = '/images/items/' .$item->id. '.png';
        $file = Storage::disk('local')->put($output_file, $image);
        $item->qrcode_image = 'storage'.$output_file;
        $item->save();
        
        if($request->file('img')){
            
            $path = 'images/items/'.$item->id.'/';
            if(!(\File::exists($path))){
                \File::makeDirectory($path);
            } 
            $files=$request->file('img');
            foreach($files as $file) {
 
                $input['img'] = $file->getClientOriginalName();
                $destinationPath = 'images/items/';
                
                $img = Image::make($file->getRealPath());
                $img->resize(800, 750, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path.$input['img']);
                $name = $path.$input['img'];
                ItemImage::insert( [
                    'img'=>  $name,
                    'item_id'=> $item->id
                ]);
            }
        }
        return response()->json(['message' => 'تم اضافة المكان بنجاح']);
    }

    //edit item from dashboard vendor
    public function editItem($id) {
        $item = Item::where('id',$id)->first();
        $categories = Category::all();
        $item_id = $item->id;
        $item_categories = CategoryItem::where('item_id',$item_id)->get();
        $cities = City::all();
        return response()->json($item);
    }

    //update item from dashboard vendor
    public function updateItem(Request $request,$id){

        $item = Item::where('id',$id)->first();
        $item_id = $item->id;
        $item_categories = CategoryItem::where('item_id',$item_id)->delete();
        $request->validate([
            'item_title_ar'   => 'required',
        ],
        [
            'item_title_ar.required'   => 'هذا الحقل مطلوب',
        ]);
        $meta_title_ar      =$request->item_title_ar;
        $meta_title_en      =$request->item_title_en;
        $meta_keywards_ar   =$request->item_title_ar;
        $meta_keywards_en   =$request->item_title_en;
        $meta_Discription_ar=$request->item_desc_ar;
        $meta_Discription_en=$request->item_desc_en;
        
        $data = [
            'city_id'              => $request->item_city,
            'phone_number'         => $request->item_phone,
            'longitude'            => $request->longitude,
            'latitude'             => $request->latitude,
            'item_states'          => 2,
            'reservation_phone'    => $request->reservation_phone,
            'whatsapp_phone'       => $request->whatsapp_phone,
            'vendor_id'            => $request->vendor_id,
            'link'                 => $request->link,
            'imaging_type'         => $request->imaging_type,
            'ar' => [
                'name'             => $request->item_title_ar,
                'description'      => $request->item_desc_ar,
                'name'             => $request->item_title_ar,
                'address'          => $request-> item_address_ar,
                'description'      => $request->item_desc_ar,
                'meta_title'       => $meta_title_ar,
                'meta_keywards'    => $meta_keywards_ar,
                'meta_Discription' => $meta_Discription_ar,
                'food_menu'        => $request -> food_menu_ar,
            ],
            'en' => [
                'name'             => $request->item_title_en,
                'address'          => $request-> item_address_en,
                'description'      => $request->item_desc_en,
                'meta_title'       => $meta_title_en,
                'meta_keywards'    => $meta_keywards_en,
                'meta_Discription' => $meta_Discription_en,
                'food_menu'        => $request -> food_menu_en,
            ]
        ];

        $item->update($data);
        foreach($item->images as $img) {
            $img->delete();
        }
        
        $item_categories = $request->category;
        if($item_categories != NULL) {
            foreach($item_categories as $cat) {
                CategoryItem::insert( [
                    'category_id'=>  $cat,
                    'item_id'=> $item->id
                ]);
            }
        } 

        if($request->file('img')){
            $path = 'images/items/'.$item->id.'/';
            $files=$request->file('img');
            foreach($files as $file) {
                $input['img'] = $file->getClientOriginalName();
          
                $img = Image::make($file->getRealPath());
                $img->resize(800, 750, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path.$input['img']);
                $name = $path.$input['img'];
                ItemImage::insert( [
                    'img'=>  $name,
                    'item_id'=> $item->id
                ]);
            }
        }
        
        return response()->json(['message' => 'تم تعديل المكان بنجاح']);
    }
    
    //item from vendor id 
    public function vendorItem($id){
        $items = Item::where('vendor_id',$id)->get();
        $search_item = [];
        foreach ($items as $item){
            $item_image = ItemImage::where('item_id',$item->id)->get();

            $city = City::where('id',$item->city_id)->first();
            $categories = CategoryItem::where('item_id',$item->id)->get();
            $categories_item =[];
                foreach($categories as $category){
                $category_item = Category::where('id',$category->category_id)->first();
                array_push($categories_item,$category_item);
                }
            $final_item = array('place_data'=>$item,'place_image'=>$item_image, 'category' => $categories_item ,'city'=>$city);
            array_push($search_item,$final_item);
        }
        return response()->json($search_item);

    }
    //make QRcode to user 
    public function QRcodee($id){
        $item = Item::find($id);
        $image = \QrCode::format('png')
        ->size(500)->errorCorrection('H')
        ->generate($item->id);
        
        return response()->json($image)->header('Content-type','image/png');
    }
    ////update user profile
    public function updateprofile(Request $request,$id ){
       
        $user = User::where('id',$id)->first();
        if ($user->email != $request->email) {
            $simular_email = User::where('email',$request->email)->get();
            if (count($simular_email) > 0) {
                return response()->json(['message' => 'email has taken']);
            }   
        }

        if($request->file('image')){
            $image=$request->file('image');

            $input['image'] = $image->getClientOriginalName();
            $path = 'images/users/';
            $destinationPath = 'images/users';
            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.time().$input['image']);
            $name = $path.time().$input['image'];
          $request['img'] =  $name;
        } else {
            $request['img'] = 'images/avatar.jpg';
        }
        
        
        $data = [
            'name'           => $request->name,
            'email'          => $request->email,
            'user_type'      => $user   ->user_type,
            'phone_number'   => $request->phone_number,
            'password'       => $request->password,
            'type'           => $request['type'],
            'country'        => $request->country,
            'gender'         => $request['gender'],
            'birthday'       => $request['birthday'],
            'image'          => $request['img'],
        ];
        
        if($user->user_type == 'users'){
            $data['type'] = 0;
            $data['vendor_request'] = 0;
            $data['cancel_account'] = 0;
        }
        if($user->user_type == 'vendor'){
            $data['type'] = 0;
            $data['vendor_request'] = 1 ;
            $data['cancel_account'] = 0;
        }
        $user->update($data);
        return response()->json(['message' => 'تم تعديل البروفايل بنجاح']);

    }
    //show user profile
    public function MyProfile($id){
        $cities = City::all();
        $categories = Category::all();
        $user = User::find($id);
        return response()->json($user);
    }
    // add client to data base 
    public function client(Request $request){

        $user = User::where('id',$request->user_id)->first();
        if($user == NULL){
            return response()->json(['message'=>'undefined user']);
        }
        $item = Item::where('id',$request->item_id)->first();
        if($item ==NULL){
            return response()->json(['message'=>'undefined item']);
        }

        $clients = Client::where('user_id',$request ->user_id)->get();
        if ( count($clients) == 0){
            $client = new Client ;
            $user = User::where('id',$request->user_id)->first();
            if($user == NULL){
                return response()->json(['message'=>'undefined user']);
            }
            $item = Item::where('id',$request->item_id)->first();
            if($item ==NULL){
                return response()->json(['message'=>'undefined item']);
            }
            $client -> user_id           = $request->user_id;
            $client -> item_id           = $request->item_id;
            $client -> client_evaluation = $request->client_evaluation;
            $client -> review            = $request->review;
            $client -> count             = 1;
            $client -> client_status     = 'new';
            $client -> save();
            $avgStar = Client::where('item_id',$request->item_id)->avg('client_evaluation');
            $item = Item::where('id',$request->item_id)->first();
            $item->rating = $avgStar;
            $item->save();
        } else {
            $is_visited = false;
            foreach ($clients as $client) {
                $user = User::where('id',$request->user_id)->first();
                if($user == NULL){
                    return response()->json(['message'=>'undefined user']);
                }
                $item = Item::where('id',$request->item_id)->first();
                if($item ==NULL){
                    return response()->json(['message'=>'undefined item']);
    
                }
                if($client->item_id == $request->item_id) {
                    $is_visited = true;
                    $client -> review = $request->review;
                    $client -> client_evaluation = $request->client_evaluation;
                    $count =  $client -> count + 1;
                    $client -> count = $count;
                    switch ($count) {
                        case $count < 5:
                            $client->client_status = 'new';   
                            break;
                        case $count >= 5 && $count < 10  :
                            $client ->client_status = 'silver';
                            break;                
                        case $count >= 10  &&  $count < 15  :
                            $client ->client_status = 'gold';
                            break;
                        case $count >= 15:
                            $client ->client_status = 'diamond';
                    }
                    $client -> save();
                } 
            }
            if(!$is_visited) {
                $client = new Client ;
                $user = User::where('id',$request->user_id)->first();
                if($user == NULL){
                    return response()->json(['message'=>'undefined user']);
                }
                $item = Item::where('id',$request->item_id)->first();
                if($item ==NULL){
                    return response()->json(['message'=>'undefined item']);
                }
                $client -> user_id           = $request->user_id;
                $client -> item_id           = $request->item_id;
                $client -> client_evaluation = $request->client_evaluation;
                $client -> review            = $request->review;
                $client -> count             = 1;
                $client -> client_status     = 'new';
                $client -> save();
                $avgStar = Client::where('item_id',$request->item_id)->avg('client_evaluation');
                $item = Item::where('id',$request->item_id)->first();
                $item->rating = $avgStar;
                $item->save();
            }
        }  
        $visit = new Visit;
        $visit->item_id = $item->id;
        $visit->user_id = $user->id;
        $visit->visit_time = now();
        $visit->client_id = $client->id;
        $visit->save();
 
        // Notification
        $notification = new Notification;
        $notification->user_id = $item->vendor_id;
        $notification->data = "   العميل ($user->name)قيَم معلمك ({$item->translate('ar')->name})  ";
        $notification->data_en = "   Customer ($user->name) Rate Your Place ({$item->translate('ar')->name}) ";
        $notification->save(); 
        $vendor = User::where('id',$item->vendor_id)->first();
        $token = $vendor->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => "  العميل ($user->name) قيَم معلمك ({$item->translate('ar')->name})    ",
            'title' => " مرحبا , $vendor->name",
            'receiver' => 'erw',
            'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",
            'sound' => 'mySound'
        );
        $fields = array
        (
            'to'        => $token,
            'notification'  => $msg
        );
        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        curl_close( $ch );

        return response()->json($client);    
            
    }
    // return my offers
    public function myOffers($id){
        $user = User::find($id);
        $categories = Category::all();
        $cities = City::all();
        $to = date('2925-09-12');
        $from = Carbon::now()->toDateTimeString();
        $offers = OfferUser::whereBetween('end_offer_date', [$from, $to])->where('user_id',$id)->get();   
        $offer_user =[];
        foreach ($offers as $offer){
            $offers = Offer::where('id',$offer->offer_id)->first();
            $item   = Item::where('id',$offer->item_id)->where('item_states','1')->first();
            if($item ==null){
                return response()->json('لا يوجد عروض');
            }
            $final = array('offers'=>$offer,'text-offer'=>$offers,'item_data'=>$item);
            array_push($offer_user,$final);
        }
        return response()->json($offer_user);
    }
    //type of user
    public function typeUser($id){
        $items= Client::where('user_id',$id)->get();
        $clients = [];
        foreach($items as $item) {
            $place = Item::where('id',$item->item_id)->first();
            $place_ar = Item::where('id',$item->item_id)->first()->translate('ar')->name;
            $place_en = Item::where('id',$item->item_id)->first()->translate('en')->name;
            $image = ItemImage::where('item_id',$place->id)->first()->img;
            $final = array('visit_info'=>$item,'place_ar'=>$place_ar,'place_en'=>$place_ar,'place_img'=>$image);
            array_push($clients,$final);
        }
        return response()->json($clients);
    }
    //workTime Worktime
    public function AddWorkTime(Request $request){
    
        $data =[
            'item_id'   => $request->item_id,
            'saturday'  => $request->saturday,
            'sunday'    => $request->sunday,
            'monday'    => $request->monday,
            'tuesday'   => $request->tuesday,
            'wednesday' => $request->wednesday,
            'thursday'  => $request->thursday,
            'friday'    => $request->friday,
        ];
        $worktime = WorkTime::create($data);
        return response()->json($worktime);        
    }
    public function updateWorkTime(Request $request){
        $worktime = WorkTime::where('item_id',$request->item_id)->first();

        $data =[
            'item_id'   => $request->item_id,
            'saturday'  => $request->saturday,
            'sunday'    => $request->sunday,
            'monday'    => $request->monday,
            'tuesday'   => $request->tuesday,
            'wednesday' => $request->wednesday,
            'thursday'  => $request->thursday,
            'friday'    => $request->friday,
        ];
        $worktime->update($data);
        return response()->json($worktime);        
    }
    //top rate
    public function topRated(){
        $results = Item::where('item_states','1')->orderBy('rating', 'DESC')->take(10)->get();
        $items   =[];
        foreach($results as $result){
            $image = ItemImage::where('item_id',$result->id)->get();
            $worktimes   = WorkTime::where('item_id',$result->id)->get();
            $categories = CategoryItem::where('item_id',$result->id)->get();
            $categories_item =[];
            foreach($categories as $category){
            $category_item = Category::where('id',$category->category_id)->first();
            array_push($categories_item,$category_item);
            }
            $final = array('place_data'=>$result,'place_image'=>$image , 'worktime'=>$worktimes,'category'=>$categories_item);
            array_push($items,$final);
        }
        return response()->json($items);
    }
    //delete item
    public function deleteItem($id){
        $item = Item::where('id',$id)->first();
        foreach($item->images as $img) {
            if(\File::exists($img->img)){
                \File::delete($img->img);
        }
        }
        $path = 'images/items/'.$item->id.'/';
        if(\File::exists($path)){
            \File::deleteDirectory($path);
        }    
        $item->delete();
        return response()->json(['message' => 'تم حذف المكان بنجاح']);
    }
    //
    public function review($id){  
        $reviews = Client::where('item_id',$id)->get();
        $res =[];
        foreach($reviews as $review){
            $user  = User::where('id',$review->user_id)->get();
            $final = array('review'=>$review,'user'=>$user);
            array_push($res,$final);
        }
        return response()->json($res);
    }
    //
    public function ratingCount($id){
        $final_count = [];
        $count_one   = Client::where('item_id',$id)->where('client_evaluation','=','1')->count();
        $count_two   = Client::where('item_id',$id)->where('client_evaluation','=','2')->count();
        $count_three = Client::where('item_id',$id)->where('client_evaluation','=','3')->count();
        $count_four  = Client::where('item_id',$id)->where('client_evaluation','=','4')->count();
        $count_five  = Client::where('item_id',$id)->where('client_evaluation','=','5')->count();
        $final = array('one'=>$count_one,'two'=>$count_two,'three'=>$count_three,'four'=>$count_four,'five'=>$count_five);
        array_push($final_count,$final);
        return response()->json($final_count);
    }

    public function animatedTicker(){
        $animatedTicker= AnimatedTicker::all();
        return response()->json($animatedTicker);
    }
    
    public function offer(Request $request , $user_id ,$item_id){
        $notification = new Notification;
        $item = Item::where('id',$item_id)->first();
        $notification->user_id = $user_id;
        $notification->data = " تم ارسال عرض  من مطعم ({$item->translate('ar')->name}) يتضمن ($request->offers)  ";
        $notification->data_en = " An offer has been sent from ({$item->translate('ar')->name}) restaurant that includes ($request->offers)";
        $notification->save();
        $user = User::where('id',$user_id)->first();
        $token = $user->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => "  تم ارسال عرض  من مطعم ({$item->translate('ar')->name}) ",
            'title' => " مرحبا , $user->name",
            'receiver' => 'erw',
            'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );
        $fields = array
        (
            'to'        => $token,
            'notification'  => $msg
        );
        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        $offer = new Offer;
        $vendor = $request->vendor_id;
        $offers = offer::where('offers',$request->offers)->first();
        if ($offers == null){
            $offer->offers = $request->offers;
            $offer->vendor_id = $vendor;
            $offer->save();  
            $data_offers = new OfferUser;
            $offer->offers = $request->offers;
            $offer->vendor_id = $vendor;
            $offer->save();
            $data_offers ->vendor_id        = $vendor;
            $data_offers ->item_id          = $item_id;
            $data_offers ->user_id          = $user_id ;
            $data_offers ->offer_id         = $offer->id;
            $data_offers ->start_offer_date = $request -> start_offer_date;
            $data_offers ->end_offer_date   = $request -> end_offer_date;
            $data_offers->save();
        }else{            
        $data_offers = new OfferUser;
        $data_offers -> vendor_id        = $vendor;
        $data_offers -> item_id          = $item_id;
        $data_offers -> user_id          = $user_id ;
        $data_offers -> offer_id         = $offers->id;
        $data_offers -> start_offer_date = $request -> start_offer_date;
        $data_offers -> end_offer_date   = $request -> end_offer_date;
        $data_offers->save();
        }        
        return response()->json("تم إضافة العرض");
    }

    public function multiOffers(Request $request  ,$item_id){
        $offer = new Offer;
        $vendor = $request->vendor_id;
        $offers = offer::where('offers',$request->offers)->first();
        if ($offers == null){
            $offer->offers = $request->offers;
            $offer->vendor_id = $vendor;
            $offer->save(); 
            $client_id = $request->client_id;
            $clients_Array = explode("," , $client_id);
            foreach($clients_Array as $client_Array){
                $item = Item::where('id',$item_id)->first();
                $notification = new Notification;
                $notification->user_id = $client_Array;
                $notification->data = " تم ارسال عرض  من مطعم ({$item->translate('ar')->name}) يتضمن ($request->offers)  ";
                $notification->data_en = " An offer has been sent from ({$item->translate('ar')->name}) restaurant that includes ($request->offers)";
                $notification->save();
                $user = User::where('id',$client_Array)->first();
                $token = $user->fcm_token;  
                $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
                $msg = array
                (
                    'body'  => "  تم ارسال عرض  من مطعم ({$item->translate('ar')->name}) ",
                    'title' => " مرحبا , $user->name",
                    'receiver' => 'erw',
                    'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
                    'sound' => 'mySound'/*Default sound*/
                );
                $fields = array
                (
                    'to'        => $token,
                    'notification'  => $msg
                );
                $headers = array
                        (
                            'Authorization: key=' . $from,
                            'Content-Type: application/json'
                        );
                //#Send Reponse To FireBase Server 
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                $result = curl_exec($ch );
                curl_close( $ch );
                $data =[
                    'vendor_id'        => $request->vendor_id,
                    'item_id'          => $item_id,
                    'user_id'          => $client_Array,
                    'offer_id'         => $offer->id,
                    'start_offer_date' => $request -> start_offer_date,
                    'end_offer_date'   => $request -> end_offer_date,
                ];
                $data = OfferUser::create($data);
            }
        }else{
            $client_id = $request->client_id;
            $clients_Array = explode("," , $client_id);
            foreach($clients_Array as $client_Array){
                $item = Item::where('id',$item_id)->first();
                $notification = new Notification;
                $notification->user_id = $client_Array;
                $notification->data = " تم ارسال عرض  من مطعم ({$item->translate('ar')->name}) يتضمن ($request->offers)  ";
                $notification->data_en = " An offer has been sent from ({$item->translate('ar')->name}) restaurant that includes ($request->offers)";
                $notification->save();
                $user = User::where('id',$client_Array)->first();
                $token = $user->fcm_token;  
                $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
                $msg = array
                (
                    'body'  => "  تم ارسال عرض  من مطعم ({$item->translate('ar')->name}) ",
                    'title' => " مرحبا , $user->name",
                    'receiver' => 'erw',
                    'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
                    'sound' => 'mySound'/*Default sound*/
                );
                $fields = array
                (
                    'to'        => $token,
                    'notification'  => $msg
                );
                $headers = array
                        (
                            'Authorization: key=' . $from,
                            'Content-Type: application/json'
                        );
                //#Send Reponse To FireBase Server 
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                $result = curl_exec($ch );
                curl_close( $ch );
                $data =[
                    'vendor_id'        => $request->vendor_id,
                    'item_id'          => $item_id,
                    'user_id'          => $client_Array,
                    'offer_id'         => $offers->id,
                    'start_offer_date' => $request -> start_offer_date,
                    'end_offer_date'   => $request -> end_offer_date,
                ];
                $data = OfferUser::create($data);
            }
        }
        return response()->json($data);
    }

    public function myPlaces($id){
        $user       = User::find ($id);
        $categories = Category::all();
        $cities     = City::all();
        $items      = Item::where('vendor_id',$user->id)->get();
        return response()->json($items);
    }

    public function myClientsItem($id){
        $my_clients = Client::where('item_id',$id)->get();
        $users = [];
        $temp = [];
        foreach($my_clients as $my_client){
            $user   = User::where('id',$my_client->user_id)->first();
            $user_id = $user->id;
            if(!in_array($user_id,$temp)) {
                array_push($temp,$user_id);
                $final  = array('user_name'=>$user,'user_review'=>$my_client);
                array_push($users,$final);
            }
        }
        return response()->json($users);
        
    }


    public function showFavourite($id){
        $categories = Category::all();
        $cities     = City::all();
        $favourites =Favourite::where('user_id',$id)->get();
        $fav = [];
        foreach ($favourites as $favourite){
            $item       = Item::where('id',$favourite->item_id)->first();
            $itemimage  = ItemImage::where('item_id',$item->id)->get();
            $worktimes  = WorkTime::where('item_id',$item->id)->get();
            $categories = CategoryItem::where('item_id',$item->id)->get();
            $categories_item =[];
            foreach($categories as $category){
            $category_item = Category::where('id',$category->category_id)->first();
            array_push($categories_item,$category_item);
            }
            $final_item = array('place_data'=>$item,'place_image'=>$itemimage, 'worktime'=>$worktimes,'category'=>$categories_item);
            array_push($fav,$final_item);
        }
        return response()->json($fav);
    }

    public function addToFavourites(Request $request){
        $favourite          = new Favourite;
        $favourite->user_id = $request->user_id;
        $favourite->item_id = $request->item_id;
        $favourite->save();
        return response()->json('تم الاضافة الى المفضلة');
    }

    public function deletefromFavourite(Request $request){
        $favourite = Favourite::where('item_id',$request->item_id)->where('user_id',$request->user_id)->first();
        $favourite->delete();
        return response()->json('تم الحذف من المفضلة');
    }

    public function myNotification($id){
        $notifications = Notification::where('user_id',$id)->orderBy('created_at','ASC')->get();
        return response()->json($notifications);
    }

    public function vendorOffer(Request $request){
        $user       = User::find($request->user_id);
        $item       = Item::where('id',$request->item_id)->where('item_states','1')->first();
        if ($item ==null){
            return response()->json('لا يوجد عروض متاحة');
        }
        $categories = Category::all();
        $cities     = City::all();
        $to         = date('2925-09-12');
        $from       = Carbon::now()->toDateTimeString();
        $title      = Offer::where('offers',$request->title)->first();
        $offer      = OfferUser::whereBetween('end_offer_date', [$from, $to])->where('vendor_id',$request->user_id)->where('item_id',$item->id)->where('offer_id',$title->id)->get();       
        $offer_user = [];
        foreach ($offer as $offers){
            $user   = User::where('id',$offers->user_id)->first();
            $final  = array('offers'=>$offers ,'user'=>$user->name);
            array_push($offer_user,$final);
        }
        return response()->json($offer_user);
    }
    
    public function textOffer($id){
        $text_offers = Offer::where('vendor_id',$id)->get();
        $text =[];
        foreach($text_offers as $text_offer){
            if(in_array($text_offer->offers, $text))
            {
            }else{
                array_push($text,$text_offer->offers);
            }
        }
        return response()->json($text);
    }

    public function latestPlaces(){
        $items = Item::orderBy('created_at','DESC')->where('item_states','1')->take(10)->get();
        $items_array = [];
        foreach ($items as $item) {
            $itemimage   = ItemImage::where('item_id',$item->id)->get();
            $worktimes   = WorkTime::where('item_id',$item->id)->get();
            $categories  = CategoryItem::where('item_id',$item->id)->get();
            $categories_item =[];
            foreach($categories as $category){
            $category_item = Category::where('id',$category->category_id)->first();
            array_push($categories_item,$category_item);
            }
            $final_item = array('place_data'=>$item,'place_image'=>$itemimage , 'worktime'=>$worktimes,'category'=>$categories_item);
            array_push($items_array,$final_item);
        }
        return response()->json($items_array);
    }

    public function reserveSave(Request $request , $id){
        $categories = Category::all();
        $cities     = City::all();
        $item       = Item::where('id',$id)->first();
        $vendor     = User::where('id',$item->vendor_id)->first();
        $data =[
            'item_id'             => $id,
            'user_id'             => $request->user_id,
            'reservation_day'     => $request->reservsation_day,
            'reservation_presons' => $request->reservsation_presons,
            'reservation_time'    => $request->reservsation_time,
            'text'                => $request->text,
            'message'             => $request->message,
            'status'              => '0',
            'cancel'              => '0',
            'vendor_id'           => $vendor->id,
        ];
        $user = User::where('id',$request->user_id)->first();
        $reservation = Reservation::create($data);
        $notification = new Notification;
        $notification->user_id = $vendor->id;
        $notification->data = " وصلك طلب حجز من ($user->name) يمكنك الرد عليه الآن وقبول الحجز في مطعم ({$item->translate('ar')->name}) الخاص بك";
        $notification->data_en = " You have received a reservation request from ($user->name) you can respond to it now and accept the reservation in your restaurant ({$item->translate('ar')->name})";
        $notification->save(); 
        $token = $vendor->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => "  وصلك طلب حجز من ($user->name)  ",
            'title' => " مرحبا , $vendor->name",
            'receiver' => 'erw',
            'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );
        $fields = array
        (
            'to'        => $token,
            'notification'  => $msg
        );
        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        return response()->json('تم اضافة حجزك');
    }

    public function workHourSave($id,Request $request) {
        $item = WorkTime::where('item_id',$id)->delete();
        $opening_times = [];
        $opening_times_temp = explode("|," , $request->selected_days);
        foreach($opening_times_temp as $temp_time) {
            $temp = explode("," , $temp_time);
            array_push($opening_times,$temp);
        }
        for ($i=0; $i<count($opening_times);$i++) {
            WorkTime::insert([
                'item_id'      => $id,
                'day'          => $opening_times[$i][0],
                'opening_time' => $opening_times[$i][1],
                'close_time'   => $opening_times[$i][2],
            ]);
        } 
        return response()->json('تم اضافة اوقات الدوام');
    }

    public function bookingRequest($item_id , $vendor_id){
        $user          = User::where('id',$vendor_id)->first();
        $reservations  = Reservation::where('item_id',$item_id)->where('status','0')->where('cancel','0')->get();
        $user_reserve  = [];
        foreach ($reservations as $reservation ){
            $client  = User::where('id',$reservation->user_id)->first();
            $item    = Item::where('id',$item_id)->first();
            $final   = array('reservation'=>$reservation , 'user'=>$client , 'item'=>$item) ;
            array_push($user_reserve , $final);
           
        }
        return response()->json($user_reserve);
    }

    public function ReservationAccepted($id){
        $reservation = Reservation::where('id',$id)->first();
        $item = Item::where('id',$reservation->item_id)->first();
        $reservation->status = '1';
        $reservation->save();
        $user  = User::where('id',$reservation->user_id)->first();   
        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->data = " تم الموافقة على حجزك في مطعم ({$item->translate('ar')->name})";
        $notification->data_en = " Your restaurant reservation has been approved ({$item->translate('ar')->name})";
        $notification->save();
        $token = $user->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => " تم الموافقة على حجزك في مطعم ({$item->translate('ar')->name}) ",
            'title' => " مرحبا , $user->name",
            'receiver' => 'erw',
            'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );
        $fields = array
        (
            'to'        => $token,
            'notification'  => $msg
        );
        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        
        return response()->json('تم تأكيد حجزك');

    }

    public function ReservationCancel($id){
        $reservation = Reservation::where('id',$id)->first();
        $item = Item::where('id',$reservation->item_id)->first();
        $reservation->cancel = '1';
        $reservation->save();
        $user  = User::where('id',$reservation->user_id)->first();   
        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->data = " تم إلغاء حجزك في مطعم ({$item->translate('ar')->name}) ";
        $notification->data_en = " Your restaurant reservation has been cancelled ({$item->translate('ar')->name})";
        $notification->save();     
        $token = $user->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => "تم إلغاء حجزك في مطعم ({$item->translate('ar')->name}) ",
            'title' => " مرحبا , $user->name",
            'receiver' => 'erw',
            'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );
        $fields = array
        (
            'to'        => $token,
            'notification'  => $msg
        );
        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        return response()->json('تم الغاء الحجز');
    }

    public function suggestReservation($id , Request $request){
        $notification = new Notification;
        $notification->user_id = $id;
        $notification->data = " تم إقتراح حجز بتاريخ ($request->reservationDate) في تمام الساعه ($request->reservationTime) ";
        $notification->data_en = " A reservation was proposed on ($request->reservationDate) at ($request->reservationTime)";
        $notification->save(); 

        $user  = User::find($id);        
        $token = $user->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => "تم إقتراح حجز ",
            'title' => " مرحبا , $user->name",
            'receiver' => 'erw',
            'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );
        $fields = array
        (
            'to'        => $token,
            'notification'  => $msg
        );
        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch ); 
        return response()->json('تم اقتراح حجز'); 
    }

    public function previousReservation($id){
        $categories    = Category::all();
        $cities        = City::all();
        $user          = User::find($id);
        $reservations  = Reservation::where('vendor_id',$user->id)->get();
        $user_reserve  = [];
        foreach ($reservations as $reservation ){
            $items    = Item::where('id',$reservation->item_id)->where('item_states','1')->get();
            foreach($items as $item){
                $client  = User::where('id',$reservation->user_id)->first();
                $final   = array('reservation'=>$reservation , 'user'=>$client ,'item'=>$item) ;
                array_push($user_reserve , $final);
            }
        }
        return response()->json($user_reserve); 
    }

    public function food_menu($item_id){
        $foodMenu = Item::where('id',$item_id)->first();
        return response()->json($foodMenu->food_menu);
    }

    public function questions(){
        $questions = Question::all();
        return response()->json($questions);
    }
    public function email(Request $request){
         
        $details = [
            'name' =>$request->name,
            'email'=>$request->email,
            'body' =>$request->body,
        ];
        mail::to('hussenmohammad915@gmail.com')->send(new \App\Mail\NewMail($details));
        return response()->json('success');
    }
    public function userReservation($id){
        $reservations  = Reservation::where('user_id',$id)->get();
        $user_reserve  = [];
        foreach ($reservations as $reservation ){
            $client  = User::where('id',$reservation->user_id)->first();
            $item    = Item::where('id',$reservation->item_id)->first();
            $final   = array('reservation'=>$reservation , 'user'=>$client ,'item'=>$item) ;
            array_push($user_reserve , $final);
        }
        return response()->json($user_reserve); 
    }
    public function generalPage(){
        return response()->json('dd');
        $general = GeneralPage::all();
        return response()->json($general);
    }
    public function latestCityPlce($id){
        $items = Item::orderBy('created_at','DESC')->where('item_states','1')->take(5)->where('city_id',$id)->get();
        $items_array = [];
        foreach ($items as $item) {
            $itemimage  = ItemImage::where('item_id',$item->id)->get();
            $worktimes   = WorkTime::where('item_id',$item->id)->get();
            $categories = CategoryItem::where('item_id',$item->id)->get();
            $categories_item =[];
            foreach($categories as $category){
            $category_item = Category::where('id',$category->category_id)->first();
            array_push($categories_item,$category_item);
            }
            $final_item = array('place_data'=>$item,'place_image'=>$itemimage , 'worktime'=>$worktimes ,'category'=>$categories_item);
            array_push($items_array,$final_item);
        }
        return response()->json($items_array);
    }
    public function appImage(){
        $app_image = AppImage::all();
        return response()->json($app_image);
    }
    public function numberNotifiction($id){
        $notifictions       = Notification::where('user_id',$id)->get();
        $notifiction_count  = count($notifictions);
        return response()->json($notifiction_count);
    }
    public function readNotification($id){
        $notifications = Notification::where('user_id',$id)->orderBy('created_at','ASC')->get();
        foreach($notifications as $notification){
            $notification->status = 1;
            $notification->save();
        }

        return response()->json($notifications);
    }
    public function sendContact(Request $request) {
        $data = array('name'=> $request->name, 'email' => $request->email, 'subject' => $request->subject,'phone' => $request->phone, 'message_txt' =>$request->message );
        Mail::send('front_views.mail', $data, function($message) use ($data) {
           $message->to('hussenmohammad915@gmail.com', 'Message from website')->subject
              ($data['subject']);
           $message->from($data['email'], $data['name']);
        });
        
      return response()->json('تم ارسال رسالتك بنجاح');
    }
    public function forgot() {
        $credentials = request()->validate(['email' => 'required|email']);
        $user = User::where('email',$credentials['email'])->first();
        if($user ==null){
            return response()->json('الايميل غير مسجل');
        }
        Password::sendResetLink($credentials);
        return response()->json(["msg" => 'Reset password link sent on your email id.']);
    }
    public function birthday($item_id){
        $clients = Client::where('item_id',$item_id)->get();
        $user_birthday = [];
        foreach($clients as $client){
            $user = User::where('id',$client->user_id)->first();
            $fdate = $user->birthday;
            $tdate = now();
            $datetime1 = new DateTime($fdate);
            $datetime2 = new DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            if($interval->m ==11 && $interval->d >= 25){
                $final =  array('user'=>$user , 'birthday after'=>$interval->d );
                array_push($user_birthday , $final);
                //return response()->json($final);
            }
        }
        return response()->json($user_birthday);
    }
    public function clientVisits($item_id,$user_id){
        $visits = Visit::where('item_id',$item_id)->where('user_id',$user_id)->get();
        return response()->json($visits);
    }
    public function AddEvent(Request $request , $user_id){
        $data = [
            'user_id' =>$user_id,
            'event'   =>$request->event,
            'time'    =>$request->time,
        ];
        $event = Event::create($data);
        return response()->json($event);
    }
    public function updateEvent(Request $request,$event_id){
        $event = Event::where('id',$event_id)->first();
        
        $data = [
            'event'   =>$request->event,
            'time'    =>$request->time,
        ];
        $event->update($data);
        return response()->json($event);
    }
    public function myEvent($user_id){
        $events =Event::where('user_id',$user_id)->get();
        return response()->json($events);
    }
    public function itemEvent($item_id){
        $clients = Client::where('item_id',$item_id)->get();
        $item_event =[];
        foreach($clients as $client){
            $events = Event::where('user_id',$client->user_id)->get();
            foreach($events as $eve){
                $user = User::where('id',$client->user_id)->first();
                $final = array('name'=>$user->name,'image'=>$user->image , 'user_id'=>$user->id , 'event'=>$eve->event , 'event_itime'=>$eve->time,'visited'=>$client->count ,'type'=>$client->client_status) ;
                array_push($item_event ,$final );
            }
        }
        return response()->json($item_event);
    }
    public function allEvent($item_id){
        $events = Event::orderBy('time', 'desc')->get()->groupBy(function($val) {
            return Carbon::parse($val->time)->format('m');
        });
        $event_details = [];
        foreach ($events as $event){
            foreach($event as $eve){
                $user = User::where('id',$eve->user_id)->first();
                $client = Client::where('user_id',$eve->user_id)->first();
                if($client != null ){
                    $final = array('name'=>$user->name,'image'=>$user->image , 'user_id'=>$user->id , 'event'=>$eve->event , 'event_itime'=>$eve->time,'visited'=>$client->count ,'type'=>$client->client_status) ;
                }else{
                    $final = array('name'=>$user->name,'image'=>$user->image , 'user_id'=>$user->id , 'event'=>$eve->event , 'event_itime'=>$eve->time) ;
                }
                array_push($event_details , $final);
            }
        }
        return response()->json($event_details);
    }
    public function destroyEvent($event_id){
        $event= Event::where('id',$event_id)->first();
        $event->delete();
        return response()->json('تم حذف المناسبة بنجاح');
    }
    public function workTimeId($item_id){
        $work_times = WorkTime::where('item_id',$item_id)->get();
        return response()->json($work_times);
    }
    public function reserveByOffer(Request $request , $id , $offer_id){
        $offer = OfferUser::where('id',$offer_id)->first();
        if($offer->used == 0){
            $offer->used = 1;
            $offer->save();
            $categories = Category::all();
            $cities     = City::all();
            $item       = Item::where('id',$id)->first();
            $vendor     = User::where('id',$item->vendor_id)->first();
            $data =[
                'item_id'             => $id,
                'user_id'             => $request->user_id,
                'reservation_day'     => $request->reservsation_day,
                'reservation_presons' => $request->reservsation_presons,
                'reservation_time'    => $request->reservsation_time,
                'text'                => $request->text,
                'message'             => $request->message,
                'status'              => '0',
                'cancel'              => '0',
                'vendor_id'           => $vendor->id,
            ];
            $user = User::where('id',$request->user_id)->first();
            $reservation = Reservation::create($data);
            $notification = new Notification;
            $notification->user_id = $vendor->id;
            $notification->data = " وصلك طلب حجز من ($user->name) يمكنك الرد عليه الآن وقبول الحجز في مطعم ({$item->translate('ar')->name}) الخاص بك";
            $notification->data_en = " You have received a reservation request from ($user->name) you can respond to it now and accept the reservation in your restaurant ({$item->translate('ar')->name})";
            $notification->save(); 
            $token = $vendor->fcm_token;  
            $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
            $msg = array
            (
                'body'  => "  وصلك طلب حجز من ($user->name)  ",
                'title' => " مرحبا , $vendor->name",
                'receiver' => 'erw',
                'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
            );
            $fields = array
            (
                'to'        => $token,
                'notification'  => $msg
            );
            $headers = array
                    (
                        'Authorization: key=' . $from,
                        'Content-Type: application/json'
                    );
            //#Send Reponse To FireBase Server 
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
            return response()->json('تم اضافة حجزك');
        }else{
            return response()->json('لا يمكنك الاستفاده من العرض اكثر من مرة ');
        }
    }
    public function AddComplaint(Request $request , $item_id , $user_id){
        $user = User::where('id',$user_id)->first();
        $item = Item::where('id',$item_id)->first();
        $data = [
            'item_id' => $item_id,
            'user_id' => $user_id,
            'title'   => $request->title,
            'text'    => $request->text,
        ];
        $complaint = Complaint::create($data);
        $data = [
            'user_id' => $item->vendor_id ,
            'data' => "تم إضافة شكوى من قبل ($user->name) لمعلمك {$item->translate('ar')->name} ",
            'data_en'=>"A complaint was added by ($user->name) to  {$item->translate('en')->name}",
            'status'=> '1'
        ];
        $notification = Notification::create($data);
        if($request->file('image')){
            
            $path = 'images/complaint/'.$complaint->id.'/';
            if(!(\File::exists($path))){
                \File::makeDirectory($path);
            } 
            $files=$request->file('image');
            foreach($files as $file) {
 
                $input['image'] = $file->getClientOriginalName();
                $destinationPath = 'images/complaint/';
                
                $img = Image::make($file->getRealPath());
                $img->resize(800, 750, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path.$input['image']);
                $name = $path.$input['image'];
                ComplaintImage::insert( [
                    'image'=>  $name,
                    'complaint_id'=> $complaint->id
                ]);
            }
        }
        return response()->json($complaint);
    }
    public function itemComplaint($item_id){
        $complaints = Complaint::where('item_id',$item_id)->get();
        $complaint_details =[];
        foreach($complaints as $complaint){
            $user  = User::where('id',$complaint->user_id)->first();
            $image = ComplaintImage::where('complaint_id',$complaint->id)->get();
            $final = array('complaint'=>$complaint , 'image'=>$image , 'user_name'=>$user->name , 'user_image'=>$user->image);
            array_push($complaint_details , $final);
        }
        return response()->json($complaint_details);
    }
    public function userComplaint($user_id){
        $complaints = Complaint::where('user_id',$user_id)->get();
        $complaint_details =[];
        foreach($complaints as $complaint){
            $item  = Item::where('id',$complaint->item_id)->first();
            $image = ComplaintImage::where('complaint_id',$complaint->id)->get();
            $final = array('complaint'=>$complaint , 'image'=>$image , 'item'=>$item->name  );
            array_push($complaint_details , $final);
        }
        return response()->json($complaint_details);
    }
    public function reply(Request $request , $comp_id){
        $complaint = Complaint::where('id',$comp_id)->first();
        $complaint->reply = $request->reply;
        $complaint->save();

        $data = [
            'user_id' => $complaint->user_id ,
            'data' => "تم الرد على شكواك  من قبل صاحب المعلم ",
            'data_en'=>"Your complaint has been answered by the owner of the place",
            'status'=> '1'
        ];
        $notification = Notification::create($data);
        return response()->json($complaint);
    }
}