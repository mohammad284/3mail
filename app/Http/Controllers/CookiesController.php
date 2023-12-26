<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookiesController extends Controller
{
    public function setCookie(Request $request){
        dd('cc');
        $minutes = 60;
        $response = new Response('Set Cookie');
        $response->withCookie(cookie('name', 'MyValue', $minutes));
        return $response;
     }

     public function getCookie(Request $request){
         dd('zz');
        $value = $request->cookie('name');
        echo $value;
     }

}
