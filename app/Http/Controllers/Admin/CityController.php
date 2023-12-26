<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Item;
use App\ItemImage;
use App\Category;
use App\CategoryItem;
use App\City;
use Image;


class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
    }

        // Show all Cities
    public function admin() {
      $cities = City::orderBy('id','DESC')->paginate(15);
      return view('dashboard.city.city',compact('cities'));
    }

         // Go to add new city page

    public function create() {
      $Cities = City::all();
      return view('dashboard.city.city-add',compact('Cities'));
    }



    // store city####
    public function store(request $request){
        $city=new City;
        $last_cit = City::latest('id')->first();
            if ($last_cit == NULL) {
              $i = 1;
            } else {
            $i = $last_cit->id + 1;
            }
        $request->validate([
            'city_name_ar'=>'required',
            'img'         => 'required',
            'longitude'   => 'required',
            'latitude'    => 'required',
            ],
            [
            'city_name_ar.required' => 'هذا الحقل مطلوب',
            'img.required'          => 'هذا الحقل مطلوب',
            'longitude.required'    => 'يرجى تحديد الموقع على الخريطة'
            ]);

        $city_name_ar        =$request->city_name_ar;
        $city_name_en        =$request->city_name_en;
        $meta_title_ar       =$request->meta_title_ar;
        $meta_title_en       =$request->meta_title_en;
        $meta_keywards_ar    =$request->meta_keywards_ar;
        $meta_keywards_en    =$request->meta_keywards_en;
        $meta_Discription_ar =$request->meta_Discription_ar;
        $meta_Discription_en =$request->meta_Discription_en;

        $data = [
          'longitude' => $request->longitude,
          'latitude'  => $request->latitude,
              'ar' => [
                  'name'             => $city_name_ar,
                  'meta_title'       => $meta_title_ar,
                  'meta_keywards'    => $meta_keywards_ar,
                  'meta_Discription' => $meta_Discription_ar,
                    ],
              'en' => [
              'name'                 => $city_name_en,
              'meta_title'           => $meta_title_en,
              'meta_keywards'        => $meta_keywards_en,
              'meta_Discription'     => $meta_Discription_en,
                ]
        ];

          if($request->file('img')){
              $image=$request->file('img');

              $input['img'] = $image->getClientOriginalName();
              $path = 'images/city/';
              $destinationPath = 'images/city';
              $img = Image::make($image->getRealPath());
              $img->resize(500, 500, function ($constraint) {
                  $constraint->aspectRatio();
              })->save($destinationPath.'/'.time().$input['img']);
              $name = $path.time().$input['img'];
            $data['image'] =  $name;
          }

        $city->create($data);
        return redirect('/admin/cities')->with('message','تم إضافة مدينة جديدة بنجاح');
    }

    //city edit########
    public function edit($id) {
      $city = City::where('id',$id)->first();
      return view('dashboard.city.city-edit',compact('city'));
    } 

    public function update(Request $request, $id) {
      
        $city = City::where('id',$id)->first();
        $city_name_ar        = $request->city_name_ar;
        $city_name_en        = $request->city_name_en;
        $meta_title_ar       = $request->meta_title_ar;
        $meta_title_en       = $request->meta_title_en;
        $meta_keywards_ar    = $request->meta_keywards_ar;
        $meta_keywards_en    = $request->meta_keywards_en;
        $meta_Discription_ar = $request->meta_Discription_ar;
        $meta_Discription_en = $request->meta_Discription_en;
        $data = [
          'longitude'  => $request->longitude,
          'latitude'   => $request->latitude,
              'ar' => [ 
              'name'              => $city_name_ar,
              'meta_title'        => $meta_title_ar,
              'meta_keywards'     => $meta_keywards_ar,
              'meta_Discription'  => $meta_Discription_ar,
                  ],
              'en' => [
              'name'              =>$city_name_en,
              'meta_title'        => $meta_title_en,
              'meta_keywards'     => $meta_keywards_en,
              'meta_Discription'  => $meta_Discription_en,]
              ]; 
        
              if($request->file('img')){
                $image=$request->file('img');
                $input['img'] = $image->getClientOriginalName();
                $path = 'images/city/';
                $destinationPath = 'images/city';
                $img = Image::make($image->getRealPath());
                $img->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.time().$input['img']);
                $name = $path.time().$input['img'];
                
               $data['image'] =  $name;
              }
        $city->update($data);
        return redirect()->back()->with('message','تم تعديل بيانات المدينة بنجاح');
    }
      
    public function imagedelete($id) {
        $img = CityImage::where('id',$id)->first();
        $city_id = $img->City_id ;
        $images = CityImage::where('City_id',$city_id)->get();
          if (count($images) > 1) {
              $path = 'images/city/';
                if(\File::exists($img->img)){
                    \File::delete($img->img);
                }
              $img->delete();
            return redirect()->back()->with('message','تم حذف الصورة بنجاح');
          } else {
        return redirect()->back()->with('message','لايمكنك حذف الصورة، يجب أن يكون للمنتج صورة واحدة على الأقل');
          }
    }

    public function cityItems($id) {
      $items = Item::where('city_id',$id)->orderBy('id','DESC')->paginate(15);
      return view('dashboard.item.item-city',compact('items'));

    }

    //delete city ####
    public function destroy($id) {
        $city = City::where('id',$id)->first();
        $items = Item::where('city_id',$id)->get();
        foreach ($items as $item){
          $place_images = ItemImage::where('item_id',$item->id)->get();
          foreach($place_images as $img) {
            if(\File::exists($img->img)){
              \File::delete($img->img);
            }
            $img->delete();
          }
          $item->delete();
        }
        $city->delete();
      return redirect('/admin/cities')->with('message','تم حذف المدينة بنجاح');
    }


}
