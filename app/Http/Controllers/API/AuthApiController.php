<?php
namespace App\Http\Controllers\API;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Image;
use Illuminate\Support\Facades\Storage;


class AuthApiController extends Controller
{
    public function register(Request $request) {

        if($request['user_type'] == 'users'){
            $request['user_type']      = 'users';
            $request['type']           = 0;
            $request['vendor_request'] = 0;
            $request['cancel_account'] = 0;
        }
        if($request ['user_type'] == 'vendor'){
            $request['type']           = 0;
            $request['vendor_request'] = 1 ;
            $request['cancel_account'] = 0;
        }

        $validator = Validator::make($request->all(), [
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'    => ['required', 'string', 'min:6', 'confirmed'],
            'country'     =>'required',
            'phone_number'=>['required', 'unique:users'],
            'user_type'   => 'required',

        ]);


        if ($request['image'] == NUll){
            $request['image'] = 'images/avatar.jpg';
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
        }


        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $user = User::create([
            'name'            => $request['name'],
            'email'           => $request['email'],
            'user_type'       => $request['user_type'],
            'phone_number'    => $request['phone_number'],
            'password'        => $request['password'],
            'vendor_request'  => $request['vendor_request'],
            'type'            => $request['type'],
            'cancel_account'  => $request['cancel_account'],
            'country'         => $request['country'],
            'gender'          => $request['gender'],
            'birthday'        => $request['birthday'],
            'image'           => $request['img'],
        ]);
    
        $imageQr = \QrCode::format('png')
        ->size(150)->errorCorrection('H')
        ->generate($user->id);
       
        $output_file = '/images/users/' .$user->id. '.png';
        $file = Storage::disk('local')->put($output_file, $imageQr);
        $user->qrcode_image = 'storage'.$output_file;
        $user->save();

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
    
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
    
    
    public function login(Request $request){
        $credentials = request(['email', 'password']);
        $token = auth()->guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    
    
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully logged out']);
    }

    protected function respondWithToken($token){
    
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }

}
