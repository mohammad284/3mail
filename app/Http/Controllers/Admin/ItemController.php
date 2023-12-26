<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Item;
use App\ItemImage;
use App\Category;
use App\CategoryItem;
use App\City;
use App\User;
use App\Notification;
 use App\WorkTime;
use Image;
use File;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    //  ***** Admin Functions ***** //

    // Show all items
    public function admin() {
        $items = Item::where('item_states',1)->orderBy('id','DESC')->paginate(15);
        return view('dashboard.item.item',compact('items'));
    }
    
    // Go to add new item page
    public function create() {
        $categories = Category::all();
        $cities = City::all();
        return view('dashboard.item.item-add',compact('categories','cities'));
    }
    
    // Add new item
    public function store(Request $request) {
        //dd($request);
        $request->validate([
            'item_title_ar'   => 'required',
            'item_desc_ar'    => 'required',
            'item_phone'      => 'required',
            'item_address_ar' => 'required',
            'item_city'       => 'required',
            'img'             => 'required',
            'category'        => 'required',
            'longitude'       => 'required',
            'latitude'        => 'required',
            'imaging_type'    => 'required'
        ]/*,
        [
            'item_title_ar.required'   => 'هذا الحقل مطلوب',
            'item_desc_ar.required'    => 'هذا الحقل مطلوب',
            'item_address_ar.required' => 'هذا الحقل مطلوب',
            'item_phone.required'      => 'هذا الحقل مطلوب',
            'item_city.required'       => 'هذا الحقل مطلوب',
            'img.required'             => 'هذا الحقل مطلوب',
            'category.required'        => 'هذا الحقل مطلوب',
            'imaging_type.required'    => 'هذا الحقل مطلوب',
            'longitude.required'       => 'يرجى تحديد المكان على الخريطة'
        ]*/);
        
        $meta_title_ar        =$request->meta_title_ar;
        $meta_title_en        =$request->meta_title_en;
        $meta_keywards_ar     =$request->meta_keywards_ar;
        $meta_keywards_en     =$request->meta_keywards_en;
        $meta_Discription_ar  =$request->meta_Discription_ar;
        $meta_Discription_en  =$request->meta_Discription_en;


        $data = [
            'item_states'           => 1,
            'city_id'               => $request -> item_city,
            'phone_number'          => $request -> item_phone,
            'longitude'             => $request -> longitude,
            'latitude'              => $request -> latitude,
            'link'                  => $request -> res_link,
            'imaging_type'          => $request -> imaging_type,
            'whatsapp_phone'        => $request -> whatsapp_phone,
            'ar' => [
                'name'              => $request-> item_title_ar,
                'address'           => $request-> item_address_ar,
                'description'       => $request-> item_desc_ar,
                'meta_title'        => $meta_title_ar,
                'meta_keywards'     => $meta_keywards_ar,
                'meta_Discription'  => $meta_Discription_ar,
                'food_menu'         => $request ->food_menu_ar,
            ],
            'en' => [
                'name'              => $request-> item_title_en,
                'address'           => $request-> item_address_en,
                'description'       => $request-> item_desc_en,
                'meta_title'        => $meta_title_en,
                'meta_keywards'     => $meta_keywards_en,
                'meta_Discription'  => $meta_Discription_en,
                'food_menu'         => $request ->food_menu_en,
            ]
        ];

        $item = Item::create($data);
        //dd($item);
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
        
        return redirect('/admin/items')->with('message','تم إضافة مكان جديد بنجاح');

    }
    
    // Show all items related to spicifice category
    public function show($id) {
        $items = Category::find($id)->items()->orderBy('id','DESC')->paginate(15);
        return view('dashboard.item.item-cat',compact('items'));
    }

    // Go to edit item page
    public function edit($id) {
        $item = Item::where('id',$id)->first();
        $categories = Category::all();
        $item_id = $item->id;
        $item_categories = CategoryItem::where('item_id',$item_id)->get();
        $cities = City::all();
        return view('dashboard.item.item-edit',compact('item','item_categories','categories','cities'));
    }
    
    public function editVendorPlace($id) {
        $item = Item::where('id',$id)->first();
        $categories = Category::all();
        $item_id = $item->id;
        $item_categories = CategoryItem::where('item_id',$item_id)->get();
        $cities = City::all();
        return view('dashboard.item.item-editVendorPlace',compact('item','item_categories','categories','cities'));
    }
    //Update item info
    public function update(Request $request, $id) {
        
        $item = Item::where('id',$id)->first();
        $item_id = $item->id;
        $item_categories = CategoryItem::where('item_id',$item_id)->delete();
        $request->validate([
            'item_title_ar'   => 'required',
            'item_title_en'   => 'required',
            'item_desc_ar'    => 'required',
            'item_desc_en'    => 'required',
            'item_address_ar' => 'required',
            'item_address_en' => 'required',
            'item_phone'      => 'required',
            'item_city'       => 'required',
            'category'        => 'required',
            'longitude'       => 'required',
            'latitude'        => 'required',
            'imaging_type'    => 'required',
            
        ],
        [
            'item_title_ar.required'   => 'هذا الحقل مطلوب',
            'item_title_en.required'   => 'هذا الحقل مطلوب',
            'item_desc_ar.required'    => 'هذا الحقل مطلوب',
            'item_address_ar.required' => 'هذا الحقل مطلوب',
            'item_address_en.required' => 'هذا الحقل مطلوب',
            'item_desc_en.required'    => 'هذا الحقل مطلوب',
            'item_phone.required'      => 'هذا الحقل مطلوب',
            'item_city.required'       => 'هذا الحقل مطلوب',
            'category'                 => 'هذا الحقل مطلوب',
        ]);
        if ($request->item_title_en == null){
            $item_title_en    = $request->item_title_ar;
        }else{
            $item_title_en    = $request->item_title_en;
        }
        $meta_title_ar        =$request->meta_title_ar;
        $meta_title_en        =$request->meta_title_en;
        $meta_keywards_ar     =$request->meta_keywards_ar;
        $meta_keywards_en     =$request->meta_keywards_en;
        $meta_Discription_ar  =$request->meta_Discription_ar;
        $meta_Discription_en  =$request->meta_Discription_en;
        $data = [
            'city_id'               => $request -> item_city,
            'phone_number'          => $request -> item_phone,
            'longitude'             => $request -> longitude,
            'latitude'              => $request -> latitude,
            'link'                  => $request -> link,
            'imaging_type'          => $request -> imaging_type,
            'whatsapp_phone'        => $request -> whatsapp_phone,
            'item_states'           => 1,
            'ar' => [
                'name'              => $request-> item_title_ar,
                'address'           => $request-> item_address_ar,
                'description'       => $request-> item_desc_ar,
                'meta_title'        => $meta_title_ar,
                'meta_keywards'     => $meta_keywards_ar,
                'meta_Discription'  => $meta_Discription_ar,
                'food_menu'         => $request ->food_menu_ar,
            ],
            'en' => [
                'name'              => $item_title_en,
                'address'           => $request-> item_address_en,
                'description'       => $request-> item_desc_en,
                'meta_title'        => $meta_title_en,
                'meta_keywards'     => $meta_keywards_en,
                'meta_Discription'  => $meta_Discription_en,
                'food_menu'         => $request ->food_menu_en,
            ]
        ];

        $item->update($data);
        if ($item->vendor_id != null){
            $user = User::where('id',$item->vendor_id)->first();
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->data = "تم قبول طلب تعديل المعلم ({$item->translate('ar')->name})";
            $notification->data_en = "Your place modification request ({$item->translate('en')->name}) has been accepted.";
            $notification->save();
            $item->item_states=1;
            $token = $user->fcm_token;  
            $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
                $msg = array
                (
                    'body'  => "تم قبول طلب تعديل المعلم ({$item->translate('ar')->name}) ",
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
                $item->save();
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

        return redirect()->back()->with('message','تم تعديل بيانات المكان بنجاح');
    }
    public function approveItem(Request $request, $id) {
        $item = Item::where('id',$id)->first();
        $item_id = $item->id;
        $item_categories = CategoryItem::where('item_id',$item_id)->delete();
        $request->validate([
            'item_title_ar'   => 'required',
            'item_title_en'   => 'required',
            'item_desc_ar'    => 'required',
            'item_desc_en'    => 'required',
            'item_address_ar' => 'required',
            'item_address_en' => 'required',
            'item_phone'      => 'required',
            'item_city'       => 'required',
            'category'        => 'required',
            'longitude'       => 'required',
            'latitude'        => 'required',
            'imaging_type'    => 'required',
            
        ],
        [
            'item_title_ar.required'   => 'هذا الحقل مطلوب',
            'item_title_en.required'   => 'هذا الحقل مطلوب',
            'item_desc_ar.required'    => 'هذا الحقل مطلوب',
            'item_address_ar.required' => 'هذا الحقل مطلوب',
            'item_address_en.required' => 'هذا الحقل مطلوب',
            'item_desc_en.required'    => 'هذا الحقل مطلوب',
            'item_phone.required'      => 'هذا الحقل مطلوب',
            'item_city.required'       => 'هذا الحقل مطلوب',
            'category'                 => 'هذا الحقل مطلوب',
        ]);
        if ($request->item_title_en == null){
            $item_title_en    = $request->item_title_ar;
        }else{
            $item_title_en    = $request->item_title_en;
        }
        $meta_title_ar        =$request->meta_title_ar;
        $meta_title_en        =$request->meta_title_en;
        $meta_keywards_ar     =$request->meta_keywards_ar;
        $meta_keywards_en     =$request->meta_keywards_en;
        $meta_Discription_ar  =$request->meta_Discription_ar;
        $meta_Discription_en  =$request->meta_Discription_en;
        $data = [
            'item_states'           => $request -> item_states,
            'city_id'               => $request -> item_city,
            'phone_number'          => $request -> item_phone,
            'longitude'             => $request -> longitude,
            'latitude'              => $request -> latitude,
            'link'                  => $request -> link,
            'imaging_type'          => $request -> imaging_type,
            'whatsapp_phone'        => $request -> whatsapp_phone,
            'ar' => [
                'name'              => $request-> item_title_ar,
                'address'           => $request-> item_address_ar,
                'description'       => $request-> item_desc_ar,
                'meta_title'        => $meta_title_ar,
                'meta_keywards'     => $meta_keywards_ar,
                'meta_Discription'  => $meta_Discription_ar,
                'food_menu'         => $request ->food_menu_ar,
            ],
            'en' => [
                'name'              => $item_title_en,
                'address'           => $request-> item_address_en,
                'description'       => $request-> item_desc_en,
                'meta_title'        => $meta_title_en,
                'meta_keywards'     => $meta_keywards_en,
                'meta_Discription'  => $meta_Discription_en,
                'food_menu'         => $request ->food_menu_en,
            ]
        ];
        $item->update($data);
        if ($item->vendor_id != null){
            $user = User::where('id',$item->vendor_id)->first();
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->data = "تم قبول طلب إضافة المعلم ({$item->translate('ar')->name})";
            $notification->data_en = " Request to add your place accepted ({$item->translate('ar')->name}) ";
            $notification->save();
            $item->item_states=1;
            $token = $user->fcm_token;  
            $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
                $msg = array
                (
                    'body'  => "تم قبول طلب إضافة المعلم ({$item->translate('ar')->name}) ",
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
                $item->save();
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

        return redirect()->back()->with('message','تم إضافة بيانات المكان بنجاح');
    }

    // Delete Sub image form item
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
            return redirect()->back()->with('message','تم حذف الصورة بنجاح');
        } else {
            return redirect()->back()->with('message','لايمكنك حذف الصورة، يجب أن يكون للمكان صورة واحدة على الأقل');
        }
    }

    // Delete item with all images form directory
    public function destroy($id) {
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
        return redirect('/admin/items')->with('message','تم حذف بيانات المكان بنجاح');
    }

    public function requestitem(){
        $items = Item::where('item_states','0')->paginate(15);
        //dd($items);
        return view('dashboard.item.item-request',compact('items'));
    }
    
    public function approve($id){
        $item = Item::find($id);
        $user = User::where('id',$item->vendor_id)->first();
        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->data = "تم قبول طلب إضافة المعلم ({$item->translate('ar')->name})";
        $notification->data_en = "The request to add your place ({$item->translate('ar')->name}) has been accepted.";
        $notification->save();
        $item->item_states=1;
        $token = $user->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
                $msg = array
                (
                    'body'  => "تم قبول طلب إضافة المعلم ({$item->translate('ar')->name})",
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
        $item->save();
        return redirect ()->back();
        
    }

    public function approveupdate($id){
        $item = Item::find($id);
        $user = User::where('id',$item->vendor_id)->first();
        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->data = " تم قبول طلب تعديل المعلم ({$item->translate('ar')->name})";
        $notification->data_en = "Your place modification request ({$item->translate('ar')->name}) has been accepted. ";
        $notification->save();
        $item->item_states=1;
        $item->update=0;
        $token = $user->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
                $msg = array
                (
                    'body'  => "تم قبول طلب تعديل المعلم ({$item->translate('ar')->name}) ",
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
        $item->save();
        return redirect ()->back();
        
    }

    public function updateItem(){
        $items = Item::where('item_states',2)->paginate(15);
        return view('dashboard.item.item-update',compact('items'));
    }
}
