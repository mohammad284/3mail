<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Category;
use Image;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        
    }

    //  ***** Admin Functions ***** //

    // Show Admin homepage
    public function admin() {
        $categories = Category::orderBy('id','DESC')->paginate(15);
        return view('dashboard.category.category',compact('categories'));
    }
    
    public function create() {
        return view('dashboard.category.category-add');
    }
    

    public function store(Request $request) {

        $category = new Category;
        $last_cat = Category::latest('id')->first();
        if ($last_cat == NULL) {
            $i = 1;
        } else {
            $i = $last_cat->id + 1;
        }
        $request->validate([
            'category_title_ar' => 'required',
            'category_title_en' => 'required',
            'img' => 'required'
        ],
        [
            'category_title_ar.required' => 'هذا الحقل مطلوب',
            'category_title_en.required' => 'هذا الحقل مطلوب',
            'img.required' => 'هذا الحقل مطلوب',
            
        ]);
        
        $category_title_ar   =$request->category_title_ar;
        $category_title_en   =$request->category_title_en;
        $meta_title_ar       =$request->meta_title_ar;
        $meta_title_en       =$request->meta_title_en;
        $meta_keywards_ar    =$request->meta_keywards_ar;
        $meta_keywards_en    =$request->meta_keywards_en;
        $meta_Discription_ar =$request->meta_Discription_ar;
        $meta_Discription_en =$request->meta_Discription_en;
        $data = [
            'ar' => [
                'name'            => $category_title_ar,
               'meta_title'       => $meta_title_ar,
               'meta_keywards'    => $meta_keywards_ar,
               'meta_Discription' => $meta_Discription_ar,
            ],
            'en' => [
            'name'                => $category_title_en,
            'meta_title'          => $meta_title_en,
            'meta_keywards'       => $meta_keywards_en,
            'meta_Discription'    => $meta_Discription_en,
        ],

        ];
       // dd($data);
        if($request->file('img')){
            $image=$request->file('img');
            $input['img'] = $image->getClientOriginalName();
            $path = 'images/category/';
            $destinationPath = 'images/category';
            // $destinationPath = '/images/category';
            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.time().$input['img']);
            $name = $path.time().$input['img'];
            
          $data['img'] =  $name;
        }
        $category->create($data);
        return redirect('/admin/categories')->with('message','تم إضافة تصنيف جديد بنجاح');
    }

    
    public function edit($id) {
        $category = Category::where('id',$id)->first();
        return view('dashboard.category.category-edit',compact('category'));
    }
    
    public function update(Request $request, $id) {
        
        $category = Category::where('id',$id)->first();

        $request->validate([
            'category_title_ar' => 'required',
            'category_title_en' => 'required',
        ],
        [
            'category_title_ar.required' => 'هذا الحقل مطلوب',
            'category_title_en.required' => 'هذا الحقل مطلوب',
        ]);
        
        $category_title_ar   =$request->category_title_ar;
        $category_title_en   =$request->category_title_en;
        $meta_title_ar       =$request->meta_title_ar;
        $meta_title_en       =$request->meta_title_en;
        $meta_keywards_ar    =$request->meta_keywards_ar;
        $meta_keywards_en    =$request->meta_keywards_en;
        $meta_Discription_ar =$request->meta_Discription_ar;
        $meta_Discription_en =$request->meta_Discription_en;
        $data = [
            'ar' => [
                'name'             => $category_title_ar,
                'meta_title'       => $meta_title_ar,
                'meta_keywards'    => $meta_keywards_ar,
                'meta_Discription' => $meta_Discription_ar,
            ],
            'en' => [
            'name'                 => $category_title_en,
            'meta_title'           => $meta_title_en,
            'meta_keywards'        => $meta_keywards_en,
            'meta_Discription'     => $meta_Discription_en,
            ]
        ];

        if($request->file('img')){

            if(\File::exists($category->img)){
                \File::delete($category->img);
             }
            $image=$request->file('img');
            $input['img'] = $image->getClientOriginalName();
            $path = 'images/category/';
            $destinationPath = 'images/category';
            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.time().$input['img']);
            $name = $path.time().$input['img'];
            
          $data['img'] =  $name;
        }

        $category->update($data);

        return redirect()->back()->with('message','تم تعديل بيانات التصنيف بنجاح');
    }

    public function destroy($id) {
        $category = Category::where('id',$id)->first();
          if(\File::exists($category->img)){
                \File::delete($category->img);
             }
        $category->delete();
        return redirect('/admin/categories')->with('message','تم حذف التصنيف بنجاح');
    }
}
