<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Slider;
use App\Category;
use App\Item;
use App\Brand;
use App\City;
use App\CityImage;
use App\User;
use App\GoogleMaps;
use App\Notification;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function request_accounts(){
        $users = User::where('vendor_request',1)->where('cancel_account',0)->orderBy('id','DESC')->paginate(15);
        return view('dashboard.vendor-accounts.accounts',compact('users'));
    }
    public function userAccounts(){
        $users = User::where('vendor_request',0)->where('cancel_account',0)->where('type',1)->orderBy('id','DESC')->paginate(15);
        return view('dashboard.vendor-accounts.approve_accounts',compact('users'));
    }
    public function cancelAccounts(){
        $users = User::where('cancel_account',1)->orderBy('id','DESC')->paginate(15);
        return view('dashboard.vendor-accounts.cancel_accounts',compact('users'));
    }

    public function approve($id){

        $users = User::find($id);
        $notification = new Notification;
        $notification->user_id = $users->id;
        $notification->data = "تم الموافقة على حسابك كمزود خدمة في عميل، يمكنك البدء بإضافة معالمك الآن";
        $notification->data_en = "Your account has been approved as a service provider in 3amail, you can start adding your features now";
        $notification->save();
        $token = $users->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => "تم الموافقه على حسابك كمزود خدمة في عميل، يمكنك البدء بإضافة معالمك الآن",
            'title' => " مرحبا , $users->name",
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
        $users->type=1;
        $users->vendor_request=0;
        $users->cancel_account=0;
        $users->save();
        return redirect()->back();
    }
    
    //public function cancel_vendor($id){
        //$users = User::find($id);
        //$notification = new Notification;
        //$notification->user_id = $users->id;
        //$notification->data = "تم تجميد حسابك";
        //$notification->data_en = "Your account has been banned";
        //$notification->save();
        //$token = $users->fcm_token;  
        //$from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        //$msg = array
        //(
        //    'body'  => "تم تجميد حسابك",
        //    'title' => " مرحبا , $users->name",
        //    'receiver' => 'erw',
        //    'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
        //    'sound' => 'mySound'/*Default sound*/
        //);
        //$fields = array
        //(
        //    'to'        => $token,
        //    'notification'  => $msg
        //);
        //$headers = array
        //        (
        //            'Authorization: key=' . $from,
        //            'Content-Type: application/json'
        //        );
        ////#Send Reponse To FireBase Server 
        //$ch = curl_init();
        //curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        //curl_setopt( $ch,CURLOPT_POST, true );
        //curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        //curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        //curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        //curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        //$result = curl_exec($ch );
        //curl_close( $ch );
        //    
        //$users->type = 0 ;
        //$users->vendor_request=0;
        //$users->cancel_account=1;
        //$users->save();
        //return redirect()->back();
    //}
    public function cancel_vendor($id){
        $user = User::find (Auth::user()->id);
        $token = "dz4dP3E9RuGuVI2jsAJ-9a:APA91bE9WXOnz2YbXj3buvhBtqXRUjkKb8FV7_m4nmHG1wIU4SnfpJMBLPPaiGdje48Imy7vp0O2mixq8rXBL6rDOtozaygdsVIq5fy4Vyj6UXWdhpY9Dv5D9Er3aiPZQhefiwdiLCKL";  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => "تم تجميد حسابك",
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
    public function active_vendor($id){
        
        $users = User::find($id);
        $notification = new Notification;
        $notification->user_id = $users->id;
        $notification->data = " تم إعادة تفعيل حسابك ";
        $notification->data_en = "Your account has been reactivated";
        $notification->save();
        $token = $users->fcm_token;  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
        (
            'body'  => "تم إعادة تفعيل حسابك",
            'title' => " مرحبا , $users->name",
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
        $users->type=1;
        $users->vendor_request=0;
        $users->cancel_account=0;
        $users->save();
        return redirect()->back();
    }

    public function showUser($id) {
        $user = User::where('id',$id)->first();
        return view('dashboard.vendor-accounts.show-account',compact('user'));
    }


}

