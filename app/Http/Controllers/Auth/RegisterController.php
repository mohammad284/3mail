<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Http\Request;
use App\City;
use App\Category;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
       //dd($data);  
      /*  $message = array(
            'name.required'     => 'الرجاء إدخال الاسم',
            'name.string'       => 'الرجاء إدخال اسم يحتوي على محارف',
            'email.required'    => 'الرجاء إدخال بريدك الإلكتروني',
            'email.email'       => 'الرجاء إدخال بريد إلكتروني صالح',
            'email.string'      => 'الرجاء إدخال بريد إلكتروني صالح',
            'email.unique'      => 'هذا البريد الإلكتروني مستخدم مسبقاً',
            'password.required' => 'الرجاء إدخال كلمة المرور', 
            'password.string'   => 'الرجاء إدخال كلمة مرور تحوي على محارف', 
            'password.min'      => 'الرجاء إدخال كلمة مرور مكونة من أكثر من 8 محارف', 
            'birthday.required' => 'الرجاء إدخال تاريخ الميلاد',
            'gender.required'   => 'الرجاء إدخال الجنس',
            
        );
    */
        return Validator::make($data, [
     
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'user_type'    => ['required'],
            'phone_number' => ['required'],

        ]);

        //dd($data);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['user_type'] == 'users'){
            $data['user_type']      = 'users';
            $data['type']           = 0;
            $data['vendor_request'] = 0;
            $data['cancel_account'] = 0;
            $data['image']          = 'images/avatar.jpg';
        }
        if($data ['user_type'] == 'vendor'){
            $data['type']           = 0;
            $data['vendor_request'] = 1 ;
            $data['cancel_account'] = 0;
            $data['image']          = 'images/avatar.jpg';
        }
        $request = request();

        if($request->file('img')){

            $image=$request->file('img');

            $input['img'] = $image->getClientOriginalName();
            $path = 'images/users/';
            $destinationPath = 'images/users';

            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.time().$input['img']);
            $name = $path.time().$input['img'];
          $data['image'] =  $name;
        }

         $data =  [
            'name'           =>$data['name'],
            'email'          =>$data['email'],
            'user_type'      =>$data['user_type'],
            'phone_number'   =>$data['phone_number'],
            'password'       =>$data['password'],
            'vendor_request' =>$data['vendor_request'],
            'type'           =>$data['type'],
            'vendor_request' =>$data['vendor_request'],
            'cancel_account' =>$data['cancel_account'],
            'country'        =>$data['country'],
            'image'          =>$data['image'],
            'gender'         =>$data['gender'],
            'birthday'       =>$data['birthday'],
        ];
        $user = User::create($data);
       
        $image = \QrCode::format('png')
        ->size(200)->errorCorrection('H')
        ->generate($user->id);
        $output_file = '/images/users/' .$user->id. '.png';
        $file = Storage::disk('local')->put($output_file, $image);
        $user->qrcode_image = 'storage'.$output_file;
        $user->save();
        return $user;
    }

    public function showRegistrationForm() {
        $cities = City::orderBy('id','DESC')->take(6)->get();
        $categories = Category::all();
        return view('auth.register',compact('cities','categories'));
    }
    
}
