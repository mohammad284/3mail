<?php
namespace App\Http\Controllers;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;
    use App\Slider;
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Foundation\Auth\RegistersUsers;
    use App\Category;
    use App\Item;
    use App\Brand;
    use App\ItemCode;
    use App\City;
    use Image;
    use App\ItemImage;
    use App\CityImage;
    use App\CategoryItem;
    use App\User;
    use App\Client;
    use App\Offer;
    use App\OfferUser;
    use Illuminate\Support\Facades\Storage;
    use Carbon\Carbon;
    use App\WorkTime;
    use App\Notification;
    use App\Reservation;

class VendorController extends Controller
{
    use RegistersUsers;
    
    public function dashboard(){
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
     return view('vendor.vendor',compact('cities','categories'));
    }

    public function MyProfile(){
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
        $user = User::find (Auth::user()->id);
        return view('vendor.MyProfile',compact('categories','cities'));
    }

    public function myplace(){
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        $user       = User::find (Auth::user()->id);
        $categories = Category::all();
        $items      = Item::where('vendor_id',$user->id)->paginate(12);
        if ($user->cancel_account == 1){
            return view('vendor.cansel',compact('user','items','categories','cities'));
        }
        return view('vendor.myplace',compact('user','items','categories','cities'));
    }
    
    public function deletePlace($id){
        $item = Item::where('id',$id)->first();

        if($item->vendor_id != null){
            $user = User::where('id',$item->vendor_id)->first();
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->data = "تم حذف المعلم الخاص بك ";
            $notification->data_en = "Your place has been deleted";
            $notification->save();
            $token = $user->fcm_token;  
            $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
            $msg = array
            (
                'body'  => "تم حذف  المعلم الخاص بك",
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
        }
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
        return redirect('/dashboard/MyPlace')->with('message','تم حذف بيانات المكان بنجاح');
    }

    public function editeplace($id){
        $item            = Item::where('id',$id)->first();
        $categories      = Category::all();
        $item_id         = $item->id;
        $item_categories = CategoryItem::where('item_id',$item_id)->get();
        $cities          = City::orderBy('id','DESC')->take(6)->get();
        return view('vendor.update',compact('item','item_categories','categories','cities'));
    }

    public function newplace(){
        $user       = User::find (Auth::user()->id);
        $categories = Category::all();
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        if ($user->cancel_account == 1){
            return view('vendor.cansel',compact('categories','cities','user'));
        }
        return view('vendor.addnewplace',compact('categories','cities','user'));
    }

    public function updateprofile(Request $request){
        $user = User::find (Auth::user()->id);
        if ($user->email != $request->email) {
           $request->validate([
                'password'     => 'required_with:password_confirmation|same:password_confirmation',
                'name'         => 'required|string',
                'email'        => 'required|email|unique:users',
                'phone_number' => 'required',
                'country'      => 'required'
            ],
            [
                'email.required' => 'required',
                'email.unique' => 'unique'
            ]);
        } else {
            $request->validate([
                'password'     => 'required_with:password_confirmation|same:password_confirmation',
                'name'         => 'required|string',
                'email'        => 'required|email',
                'phone_number' => 'required',
                'country'      => 'required',
            ],
            [
                'email.required' => 'required'
            ]);  
        }
        

        if($request['user_type'] == 'users'){
            $request['user_type'] = 'users';
            $request['type'] = 0;
            $request['vendor_request'] = 0;
            $request['cancel_account'] = 0;
        }
        if($request ['user_type'] == 'vendor'){
            $request['type'] = 0;
            $request['vendor_request'] = 1 ;
            $request['cancel_account'] = 0;
        }
        $data = [
            'name'           => $request->name,
            'email'          => $request->email,
            'user_type'      => $request->user_type,
            'phone_number'   => $request->phone_number,
            'password'       => $request->password,
            'type'           => 1,
            'vendor_request' => 0,
            'cancel_account' => 0,
            'country'        => $request->country,
            'gender'         => $request->gender,
            'birthday'       => $request->birthday,
        ];

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
          $data['image'] =  $name;
        }

        $user->update($data);
        return redirect()->back()->with('message','تم تعديل البيانات بنجاح');

    }


    public function addnewplace(Request $request){
        $user = User::find (Auth::user()->id);
        if($request->user_code != null){
            $code = User::where('code',$request->user_code)->first();
            if($code == null){
                return redirect()->back()->with('message','ادخل كود صحيح');
            }
        }
        $request->validate([
            'item_title_ar'   => 'required',
            'item_desc_ar'    => 'required',
            'item_address_ar' => 'required',
            'item_phone'      => 'required',
            'item_city'       => 'required',
            'img'             => 'required',
            'category'        => 'required',
            'longitude'       => 'required', 
            'latitude'        => 'required', 
        ]);
        

        $data = [
            'city_id'           => $request -> item_city,
            'phone_number'      => $request -> item_phone,
            'longitude'         => $request -> longitude,
            'latitude'          => $request -> latitude,
            'item_states'       => 0,
            'whatsapp_phone'    => $request -> whatsapp_phone,
            'vendor_id'         => $user    -> id,
            'imaging_type'      => "Casher",
            'link'              => $request -> link,
            'ar' => [
                'name'             => $request -> item_title_ar,
                'description'      => $request -> item_desc_ar,
                'address'          => $request -> item_address_ar,
                'meta_title'       => $request -> item_title_ar,
                'meta_keywards'    => $request -> item_desc_ar,
                'meta_Discription' => $request -> item_desc_ar,
                'food_menu'        => $request -> food_menu_ar,
            ],
            'en' => [
                'name'             => $request -> item_title_en,
                'description'      => $request -> item_desc_en,
                'address'          => $request -> item_address_en,
                'meta_title'       => $request -> item_title_en,
                'meta_keywards'    => $request -> item_desc_en,
                'meta_Discription' => $request -> item_desc_en,
                'food_menu'        => $request -> food_menu_en,
            ]
        ];
      
       // dd($data);
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
        return redirect()->back();
    }
    
    public function updateplace(Request $request, $id) {
        $user = User::find (Auth::user()->id);
        $item = Item::where('id',$id)->first();
        $item_id = $item->id;
        $item_categories = CategoryItem::where('item_id',$item_id)->delete();
        $request->validate([
            'item_title_ar'     => 'required',
            'item_desc_ar'      => 'required',
            'item_address_ar'   => 'required',
            'item_phone'        => 'required',
            'item_city'         => 'required',
            'category'          => 'required',
            'longitude'         => 'required',
            'latitude'          => 'required',
        ]);
        
        $data = [
            'city_id'           => $request -> item_city,
            'phone_number'      => $request -> item_phone,
            'longitude'         => $request -> longitude,
            'latitude'          => $request -> latitude,
            'item_states'       => 2,
            'whatsapp_phone'    => $request -> whatsapp_phone,
            'vendor_id'         => $user    -> id,
            'imaging_type'      => "Casher",
            'link'              => $request -> link,
            'ar' => [
                'name'             => $request -> item_title_ar,
                'description'      => $request -> item_desc_ar,
                'address'          => $request -> item_address_ar,
                'meta_title'       => $request -> item_title_ar,
                'meta_keywards'    => $request -> item_desc_ar,
                'meta_Discription' => $request -> item_desc_ar,
                'food_menu'        => $request -> food_menu_ar,
            ],
            'en' => [
                'name'             => $request -> item_title_en,
                'description'      => $request -> item_desc_en,
                'address'          => $request -> item_address_en,
                'meta_title'       => $request -> item_title_en,
                'meta_keywards'    => $request -> item_desc_en,
                'meta_Discription' => $request -> item_desc_en,
                'food_menu'        => $request -> food_menu_en,
            ]
        ];
        $item->update($data);

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

        return redirect('/dashboard/MyPlace');
    }

    public function myClients(){
        $user       = User::find (Auth::user()->id);
        $categories = Category::all();
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        $items      = Item::where('vendor_id',$user->id)->paginate(12);
        if(count($items) == 1) {
            $users = [];
            $my_clients = Client::where('item_id',$items[0]->id)->get();
            foreach($my_clients as $my_client){
                $user   = User::where('id',$my_client->user_id)->first();
                $final = array('user_name'=>$user,'user_review'=>$my_client);
                array_push($users,$final);
            }
            $item_id = $items[0]->id;
            return view('vendor.my-clients', compact ('cities','categories','my_clients','users','item_id'));
        }
        return view('vendor.my-places', compact ('cities','categories','items'));
    }
    
    public function myClientsItem($id){
        $categories = Category::all();
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        $my_clients = Client::where('item_id',$id)->get();
        $users = [];
        $item = Item::where('id',$id)->first();
        $item_id = $item->id;
        $user_temp = []; 
        foreach($my_clients as $my_client){
            if (!in_array($my_client->user_id,$user_temp)){
                $user   = User::where('id',$my_client->user_id)->first();
                $final = array('user_name'=>$user,'user_review'=>$my_client);
                array_push($user_temp,$my_client->user_id);
                array_push($users,$final);
            }
        }
        return view('vendor.my-clients', compact ('cities','categories','my_clients','users','item_id'));
    }
    
    public function offer(Request $request , $user_id ,$item_id){
        $user = User::where('id',$user_id)->first();
        $item = Item::where('id',$item_id)->first();
        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->data = " تم ارسال عرض  من مطعم ({$item->translate('ar')->name}) يتضمن ($request->offers)  ";
        $notification->data_en = " An offer has been sent from ({$item->translate('ar')->name}) restaurant that includes ($request->offers)";
        $notification->save();
        $vendor = User::find (Auth::user()->id);
        $offer = new Offer;
        $offers = offer::where('offers',$request->offers)->first();
        if ($offers == null){
            $offer->offers = $request->offers;
            $offer->vendor_id = $vendor->id;
            $offer->save();  
            $data_offers   = new OfferUser;
            $offer->offers = $request->offers;
            $offer->vendor_id = $vendor->id;
            $offer->save();
            $data_offers ->vendor_id        = $vendor->id;
            $data_offers ->item_id          = $item_id;
            $data_offers ->user_id          = $user_id ;
            $data_offers ->offer_id         = $offer->id;
            $data_offers ->start_offer_date = $request -> start_offer_date;
            $data_offers ->end_offer_date   = $request -> end_offer_date;
            $data_offers->save();
        }else{
        $data_offers = new OfferUser;
        $data_offers ->vendor_id = $vendor->id;
        $data_offers ->item_id = $item_id;
        $data_offers ->user_id = $user_id ;
        $data_offers ->offer_id = $offers->id;
        $data_offers ->start_offer_date = $request -> start_offer_date;
        $data_offers ->end_offer_date = $request -> end_offer_date;
        $data_offers->save();
        }
        $token = $user->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => " هناك عرض بأنتظارك  ",
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
        return redirect()->back();
    }

    public function multiOffers(Request $request  ,$item_id){
        $vendor = User::find (Auth::user()->id);
        $offer = new Offer;
        $offers = offer::where('offers',$request->offers)->first();
        if ($offers == null){
            $offer->offers    = $request->offers;
            $offer->vendor_id = $vendor->id;
            $offer->save(); 
            $client_id     = $request->client_id;
            $clients_Array = explode("," , $client_id);
            foreach($clients_Array as $client_Array){
                $item = Item::where('id',$item_id)->first();
                $notification = new Notification;
                $notification->user_id = $client_Array;
                $notification->data = " تم ارسال عرض  من مطعم ({$item->translate('ar')->name}) يتضمن ($request->offers)  ";
                $notification->data_en = " An offer has been sent from ({$item->translate('ar')->name}) restaurant that includes ($request->offers)";
                $notification->save();
                $data =[
                    'vendor_id'        => $vendor->id,
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
                $data =[
                    'vendor_id'        => $vendor->id,
                    'item_id'          => $item_id,
                    'user_id'          => $client_Array,
                    'offer_id'         => $offers->id,
                    'start_offer_date' => $request -> start_offer_date,
                    'end_offer_date'   => $request -> end_offer_date,
                ];
                $data = OfferUser::create($data);
            }
        }
        return redirect()->back();
    }

    public function myOffers(){
        $categories = Category::all();
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        $user       = User::find (Auth::user()->id);
        $to         = date('2925-09-12');
        $from       = Carbon::now()->toDateTimeString();
        $offers     = OfferUser::whereBetween('end_offer_date', [$from, $to])->where('user_id',$user->id)->get();
        $offer_user = [];
        foreach($offers as $offer){
            $text   = Offer::where('id',$offer->offer_id)->first();
            $final  = array('offers'=>$offer,'text'=>$text );
            array_push($offer_user,$final);

        }
        return view('vendor.my-offers',compact('user','offers','categories','cities'));

    }

    public function vendorOffer(){
        $categories = Category::all();
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        $user       = User::find (Auth::user()->id);
        $to         = date('2925-09-12');
        $from       = Carbon::now()->toDateTimeString();
        $offers     = OfferUser::whereBetween('end_offer_date', [$from, $to])->where('vendor_id',$user->id)->get();
        $offer_item = [];
        foreach($offers as $offer){
            $user   = User::where('id',$offer->user_id)->first();
            $item   = Item::where('id',$offer->item_id)->first();
            $offers = Offer::where('id',$offer->offer_id)->first();
            $offer_user = OfferUser::where('offer_id',$offer->offer_id)->first();
            $final  = array('user' =>$user , 'item'=>$item , 'offer'=>$offers,'start'=>$offer_user->	start_offer_date,'end'=>$offer_user->end_offer_date);
            array_push($offer_item,$final);
        }
        return view('vendor.vendor-offers',compact('user','offer_item','categories','cities'));
    }
    
    public function workHoursPlaces(){
        $user       = User::find (Auth::user()->id);
        $categories = Category::all();
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        $items      = Item::where('vendor_id',$user->id)->paginate(12);
        if(count($items) == 1) {
            $place      = Item::where('id',$items[0]->id)->first();
            $workHours  = WorkTime::where('item_id',$items[0]->id)->get();
            return view ('vendor.work-time',compact('workHours','categories','cities','place'));
        }
        return view('vendor.my-work-place', compact ('cities','categories','items'));
    }

    public function workHours($id){
        $categories = Category::all();
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        $place      = Item::where('id',$id)->first();
        $workHours  = WorkTime::where('item_id',$id)->get();
        return view ('vendor.work-time',compact('workHours','categories','cities','place'));
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
        return redirect()->back();
    }

    public function reserve($id) {
        $categories = Category::all();
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        $item       = Item::where('id',$id)->first();
        $user       = User::find (Auth::user()->id);
        $city       = City::where('id',$item->city_id)->first();
        $date       = Carbon::now()->toDateTimeString();
        $today      = Carbon::today()->format('l');
        $worktime   = WorkTime::where('item_id',$id)->get();
        return view('front_views.reserve',compact('categories','cities','item','user','city','date','today','worktime'));
    }

    public function reserveSave(Request $request , $id){
        $categories = Category::all();
        $cities     = City::orderBy('id','DESC')->take(6)->get();
        $user       = User::find (Auth::user()->id);
        $item       = Item::where('id',$id)->first();
        $vendor     = User::where('id',$item->vendor_id)->first();
        $request->validate([
            'reservation_day'      => 'required',
            'reservsation_presons' => 'required',
            'reservation_time'     => 'required',
        ]);
        $data =[
            'item_id'             => $id,
            'vendor_id'           => $vendor->id,
            'user_id'             => $user->id,
            'reservation_day'     => $request->reservation_day,
            'reservation_presons' => $request->reservsation_presons,
            'reservation_time'    => $request->reservation_time,
            'status'              => '0',
            'cancel'              => '0',

        ];
        $reservation = Reservation::create($data);
        return redirect()->back();
    }

    public function myNotification(){
        $categories    = Category::all();
        $cities        = City::orderBy('id','DESC')->take(6)->get();
        $user          = User::find (Auth::user()->id);
        $notifications = Notification::where('user_id',$user->id)->orderBy('created_at','ASC')->paginate(20);
        return view('vendor.my-notification',compact('notifications','categories','cities'));
    }
 
    public function bookingPlace(){
        $categories    = Category::all();
        $cities        = City::orderBy('id','DESC')->take(6)->get();
        $user          = User::find (Auth::user()->id);
        $items         = Item::where('vendor_id',$user->id)->paginate(12);
        if (count($items) == 1 ) {
            $reservations  = Reservation::where('item_id',$items[0]->id)->where('status','0')->where('cancel','0')->get();
            $user_reserve  = [];
            foreach ($reservations as $reservation ){
                $client  = User::where('id',$reservation->user_id)->first();
                $item    = Item::where('id',$items[0]->id)->first();
                $final   = array('reservation'=>$reservation , 'user'=>$client , 'item'=>$item) ;
                array_push($user_reserve , $final);
            }
            return view('vendor.booking-request',compact('categories','cities','user_reserve'));
        }
        return view ('vendor.booking-place',compact ('categories','cities','items'));
    }

    public function bookingRequest($item_id){
        $categories    = Category::all();
        $cities        = City::orderBy('id','DESC')->take(6)->get();
        $user          = User::find (Auth::user()->id);
        $reservations  = Reservation::where('item_id',$item_id)->where('status','0')->where('cancel','0')->get();
        $user_reserve  = [];
        foreach ($reservations as $reservation ){
            $client  = User::where('id',$reservation->user_id)->first();
            $item    = Item::where('id',$item_id)->first();
            $final   = array('reservation'=>$reservation , 'user'=>$client , 'item'=>$item) ;
            array_push($user_reserve , $final);
           
        }

        return view('vendor.booking-request',compact('categories','cities','user_reserve'));
    }

    public function ReservationAccepted($id){
        
        $reservation = Reservation::where('id',$id)->first();
        $item = Item::where('id',$reservation->item_id)->first();
        $reservation->status = '1';
        $reservation->save();
        $user  = User::where('id',$reservation->user_id)->first();
        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->data = " تم الموافقة على حجزك في مطعم ({$item->translate('ar')->name}) ";
        $notification->data_en = " Your reservation at ({$item->translate('ar')->name}) Restaurant has been approved. ";
        $notification->save();
        $token = $user->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => "تم الموافقة على الحجز ",
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
        
        return redirect()->back();
    }

    public function ReservationCancel($id){
        $reservation = Reservation::where('id',$id)->first();
        $reservation->cancel = '1';
        $reservation->save();
        $user  = User::where('id',$reservation->user_id)->first();  
        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->data = " تم إلغاء الحجز ";
        $notification->data_en = " Booking canceled ";
        $notification->save();      
        $token = $user->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => "تم إلغاء الحجز ",
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
        return redirect()->back();
    }

    public function suggestReservation($id ,Request $request){
        $notification = new Notification;
        $notification->user_id = $id;
        $notification->data = " تم إقتراح حجز بتاريخ ($request->reservationDate) في تمام الساعة ($request->reservationTime) ";
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
        return redirect()->back(); 
    }

    
    public function previousReservation(){
        $categories    = Category::all();
        $cities        = City::orderBy('id','DESC')->take(6)->get();
        $user          = User::find (Auth::user()->id);
        $reservations  = Reservation::where('vendor_id',$user->id)->orderBy('id','DESC')->get();
        $user_reserve  = [];
        foreach ($reservations as $reservation ){
            $client  = User::where('id',$reservation->user_id)->first();
            $item    = Item::where('id',$reservation->item_id)->first();
            $final   = array('reservation'=>$reservation , 'user'=>$client ,'item'=>$item) ;
            array_push($user_reserve , $final);
        }
        return view('vendor.previous-reservation',compact('categories','cities','user_reserve'));
    }

    public function userReservation() {
        $categories    = Category::all();
        $cities        = City::orderBy('id','DESC')->take(6)->get();
        $user          = User::find (Auth::user()->id);
        $reservations  = Reservation::where('user_id',$user->id)->get();
        $user_reserve  = [];
        foreach ($reservations as $reservation ){
            $client  = User::where('id',$reservation->user_id)->first();
            $item    = Item::where('id',$reservation->item_id)->first();
            $final   = array('reservation'=>$reservation , 'user'=>$client ,'item'=>$item) ;
            array_push($user_reserve , $final);
        }
        return view('vendor.user-reservation',compact('categories','cities','user_reserve'));
    }
    
    public function imagedelete($id) {
        $img = ItemImage::where('id',$id)->first();
        $item_id = $img->item_id;
        $images = ItemImage::where('item_id',$item_id)->get();
        if (count($images) > 1) {
             $path = 'images/items/';
            if(\File::exists($img->img)){
                \File::delete($img->img);
            }
            $img->delete();
            return redirect()->back()->with('message','done');
        } else {
            return redirect()->back()->with('message','faild');
        }
    }

}