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
        $quest = Question::count();
        return array("testCount"=>$test, "AnswerCount"=>$quest);
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
    public function tests(Request $request)
    {
        $id = $request->id;
        
        return Test::where("id",  $id)->with(["Question.Answers"])->get()->toJson();;
    }
    public function getAllTests()
    {
        $tests = Test::where("enable", 1)->get();

        return $tests;
    }
    public function getSettings(Request $request)
    {
        $id = $request->id;
        $settings = Test::where("id", "=", $id)->with(["Settings"])->first();
        return $settings;
    }
    public function getTestforUser(Request $request)
    {
        $id = $request->id;
        $test = Test::where("id", $id)->with(["Question.Answers"])->first();
        return $test;
    }
}
