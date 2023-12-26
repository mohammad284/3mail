<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use App\Notifications\SendPushNotification;

class FCMController extends Controller
{
    public function index(){

        return view('fcm');
    }
    public function storeToken(Request $request)
    {
        return $request;
        auth()->user()->update(['device_key'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }
    public function sendNotification(){
        $token = "cJiEmUNnyFTwdDVgQT1ehV:APA91bEUgiaOTWFjXCw9IbrzSnj2_KglSnv7vWdW8q3TzjDfPlOQ3u0lyt8nKoil8D-f2W8EAxlBkk9n_7-nxlXoMf2LNDDGSoapmqYZt375LwWossLVSy61dmoAnCGR-V0QIzFtEe0w";  
        $from  = "AAAAGgKH5ng:APA91bHuNCAuFI_PFRMsgve16ePXd5xuIk-ETudb2xTrHi2mc0ncVDwh3sLA-CCLeqaYhDNLpBR5X6hZ0-oJqw-1RhR1vApEt5ywOjbd1i3_mPpBwz-74gVQUxZm4MKMuQpESh34IQY_";
        $msg = array
              (
                'body'  => "  مرحبا يزن ",
                'title' => "مرحبا يزن",
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
        return view ('fcm',compact('result'));
    }

    public function saveToken(Request $request)
    {
        $aa=  auth()->user()->update(['fcm_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
    

   
}