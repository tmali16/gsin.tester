<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Test;
use App\Answer;
use App\Typequestion;

class TestController extends Controller
{
    //


    public function Newtest(Request $request)
    {
        $name = $request->input("name_test");
        $descript = $request->input("test_description");

        $rules = [
            "name_test" => "required|min:2",
            "description" => "nullable|min:2",
        ];
        $test = new Test();
        if($this->validate($request, $rules, [])){            
            $test->name = $name;
            $test->description = $descript;
            $test->user_id =\Auth::id();
            $test->save();
        }
        return redirect()->to("admin/tests");
    }
    public function New_question()
    {
        return view("admin.new_test");
    }

    public function test(Request $request)  
    {
        $test = Test::count();

        return $test;
    }

    public function GetQuestion()
    {
        $type = Typequestion::all();
        $question = Question::all();
        $test = Test::all();
        $ret = [            
            'type' =>$type,
            'question'=>$question,
            'tests' =>$test            
        ];
        return json_encode($ret, JSON_PRETTY_PRINT);
    }
}
