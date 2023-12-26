<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AnimatedTicker;

class AnimatedTickerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        $animatedTickes = AnimatedTicker::all();
        return view('dashboard.AnimatedTicker.index',compact('animatedTickes'));
    }

    public function create(){

        return view('dashboard.AnimatedTicker.add');

    }
    public function store(Request $request) {

        $animatedTicker = new AnimatedTicker;
        $title_ar = $request->title_ar;
        $title_en = $request->title_en;
        $data = [
            'title_ar' => $title_ar,
            'title_en' => $title_en,
        ];
        $animatedTicker->create($data);
        return redirect('/admin/animatedTicker')->with('message','تم إضافة الجملة  بنجاح');

    }
    public function edit($id) {
        $animatedTicker = AnimatedTicker::where('id',$id)->first();
        return view('dashboard.AnimatedTicker.edit',compact('animatedTicker'));
    }

    public function update(Request $request, $id) {
        
        $animatedTicker = AnimatedTicker::where('id',$id)->first();
        $title_ar = $request->title_ar;
        $title_en = $request->title_en;
        $data = [
            'title_ar' => $title_ar,
            'title_en' => $title_en,
        ];
        $animatedTicker->update($data);
        return redirect()->back()->with('message','تم تعديل بيانات الجملة بنجاح');
    }

    public function delete($id) {
        $animatedTicker = AnimatedTicker::where('id',$id)->first();
        $animatedTicker->delete();
        return redirect('/admin/animatedTicker')->with('message','تم حذف الجملة بنجاح');
    }

}
