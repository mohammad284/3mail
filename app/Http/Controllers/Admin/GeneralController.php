<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GeneralPage;
use App\AppImage;
use App\UserLogin;
use Image;
class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function privacyPage() {
        $privacy = GeneralPage::first();
        return view('dashboard.general.privacy-page',compact('privacy'));
    }

    public function savePrivacyPage(Request $request){
        $privacy = GeneralPage::first();
        $request->validate([
            'privacy_policy_ar' =>'required',
            'privacy_policy_en' => 'required',
            ],
            [
            'privacy_policy_ar.required' => 'هذا الحقل مطلوب',
            'privacy_policy_en.required'          => 'هذا الحقل مطلوب',
        ]);
        $data = [
            'ar' => [
                'privacy_policy' => $request->privacy_policy_ar
            ],
            'en' => [
                'privacy_policy' => $request->privacy_policy_en
            ],
        ];
        $privacy->update($data);
        return redirect()->back();
    }

    public function termPage() {
        $term = GeneralPage::first();
        return view('dashboard.general.term-page',compact('term'));
    }

    public function saveTermPage(Request $request){
        $term = GeneralPage::first();
        $request->validate([
            'term_ar' =>'required',
            'term_en' => 'required',
            ],
            [
            'term_ar.required' => 'هذا الحقل مطلوب',
            'term_en.required'          => 'هذا الحقل مطلوب',
        ]);
        $data = [
            'ar' => [
                'Terms_and_conditions' => $request->term_ar
            ],
            'en' => [
                'Terms_and_conditions' => $request->term_en
            ],
        ];
        $term->update($data);
        return redirect()->back();
    }

    public function aboutAppPage() {
        $about_app = GeneralPage::first();
        return view('dashboard.general.about-app-page',compact('about_app'));
    }

    public function saveAboutAppPage(Request $request){
        $about_app = GeneralPage::first();
        $request->validate([
            'about_app_ar' =>'required',
            'about_app_en' => 'required',
            ],
            [
            'about_app_ar.required' => 'هذا الحقل مطلوب',
            'about_app_en.required'          => 'هذا الحقل مطلوب',
        ]);
        $data = [
            'ar' => [
                'about' => $request->about_app_ar
            ],
            'en' => [
                'about' => $request->about_app_en
            ],
        ];
        $about_app->update($data);
        return redirect()->back();
    }


    public function appImage(){
        $img = AppImage::first();
        return view('dashboard.general.app-image',compact('img'));
    }

    public function storeImage(Request $request){
        if($request->file('app_image')){
            $image=$request->file('app_image');
        
            $input['app_image'] = $image->getClientOriginalName();
            $path = 'images/appimage/';
            $destinationPath = 'images/appimage';
            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.time().$input['app_image']);
            $name = $path.time().$input['app_image'];
          $request['img'] =  $name;
        }

        $data = [
            'image' => $request['img']
        ];
        $data = AppImage::create($data);
        return view('dashboard.general.general',compact('general'));
    }
    public function userLogin(){
        $users = UserLogin::paginate(15);
        return view('dashboard.user-login',compact('users'));
    }
}


