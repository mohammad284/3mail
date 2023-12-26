<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;
use App\QuestionTranslation;
class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function question(){
        $questions = Question::all();
        return view('dashboard.question.questions',compact('questions'));
    }

    public function create(){
        return view('dashboard.question.add-question');
    }

    public function store(Request $request){
        $data = [
            'name' => '0',
            'ar' => [
                'question'  => $request-> question_ar,
                'answer'    => $request-> answer_ar,
            
            ],
            'en' => [
                'question'  => $request-> question_en,
                'answer'    => $request-> answer_en,
            ]
        ];
        $question = Question::create($data);
        return redirect('/admin/questions');
    }

    public function edit($id) {
        $questions = Question::where('id',$id)->first();
        return view('dashboard.question.edit-question',compact('questions'));
    }

    public function update(Request $request, $id) {
        $questions = Question::where('id',$id)->first();
        $data = [
            'name' => '0',
            'ar' => [
                'question'  => $request-> question_ar,
                'answer'    => $request-> answer_ar,
            
            ],
            'en' => [
                'question'  => $request-> question_en,
                'answer'    => $request-> answer_en,
            ]
        ];
        $questions->update($data);
        return redirect()->back();
    }

    public function delete($id) {
        $questions = Question::where('id',$id)->first();
        $questions->delete();
        return redirect()->back();
    }

}
