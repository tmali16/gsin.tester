<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Question;
use App\Test;
use App\Answer;
use App\Typequestion;
use App\Settings;
use App\Tsting;

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
            if($test->save()){
                $settings = new Settings();
                $settings->quest_random = 1;
                $settings->quest_count = 30;
                $settings->answer_random = 1;
                $settings->duration = 30;
                $settings->test_id = $test->id;
                $settings->save();
            }
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
        $user = Tsting::where("_id", $id)->first();
        $settings = $user->test->Settings;
        $test = Test::where("id", $user->test_id)->first();        
        if($settings->quest_random == 1){
            $quest = Question::where("test_id", $test->id)->orderBy(DB::raw('RAND()'))->take($settings->quest_count)->get();
        }else{
            $quest = Question::where("test_id", "=", $test->id)->get();
        }
        $ret = [
            "id"=>$test->id,
            "name"=>$test->name,
            "description"=>$test->name,
            "enable"=>$test->name,
            "user_id"=>$test->name,
            'question'=> collect($quest)->shuffle()
            
        ];

        return $ret;
    }
    public function start_test(Request $request, $id)
    {
        

        return view("index.test", ["user_id"=>$id]);
    }
    public function store(Request $request, $id)
    {
        $quest_id = $request->quest_id;
        $answer_id = $request->answer_id;
        $test_id = $request->test_id;

        return;
    }
}
