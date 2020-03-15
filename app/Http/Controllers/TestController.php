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
        //dd($request->all());
        $name_kg = $request->input("name_kg");
        $name_ru = $request->input("name_ru");
        $descript_kg = $request->input("description_kg");
        $descript_ru = $request->input("description_ru");
        $quest_count = $request->input("quest_count");
        $quest_count_num = ($quest_count == 1 ? $request->input("quest_count_num") : null);
        
        $quest_random = $request->input("quest_random");
        $answer_random = $request->input("answer_random");
        $duration = $request->input("duration");
        $duration_min = ($duration == 1 ? $request->input("duration_min") : 0);

        $rules = [
            "name_kg" => "required|min:2",
            "name_ru" => "required|min:2",
            "description_kg" => "nullable|min:2",
            "description_ru" => "nullable|min:2",
        ];

        $test = new Test();
        if($this->validate($request, $rules, [])){            
            $test->name_kg = $name_kg;
            $test->name_ru = $name_ru;
            $test->description_kg = $descript_kg;
            $test->description_ru = $descript_ru;
            $test->user_id =\Auth::id();
            if($test->save()){
                $settings = new Settings();
                $settings->quest_random = $quest_random;
                $settings->quest_count = $quest_count_num;
                $settings->answer_random = $answer_random;
                $settings->duration = $duration;
                $settings->test_id = $test->id;
                $settings->save();
            }
        }
        return redirect()->to("admin/tests");
    }
    public function edit(Request $request, $id)
    {
        $test = Test::where("id", $id)->with('Settings')->first();
        return view("admin.edit_test", ['test'=>$test]);
    }
    public function update(Request $request, $id)
    {
        
        $name_kg = $request->input("name_kg");
        $name_ru = $request->input("name_ru");
        $descript_kg = $request->input("description_kg");
        $descript_ru = $request->input("description_ru");
        $quest_count = $request->input("quest_count");
        $quest_count_num = ($quest_count == 1 ? $request->input("quest_count_num") : null);
        
        $quest_random = $request->input("quest_random");
        $answer_random = $request->input("answer_random");
        $duration = $request->input("duration");
        $duration_min = ($duration == 1 ? $request->input("duration_min") : 0);

        $rules = [
            "name_kg" => "required|min:2",
            "name_ru" => "required|min:2",
            "description_kg" => "nullable|min:2",
            "description_ru" => "nullable|min:2",
        ];

        $test = Test::where('id', $id)->first();
        $settings = Settings::where("test_id", $test->id)->first();
        if($this->validate($request, $rules, [])){            
            $test->name_kg = $name_kg;
            $test->name_ru = $name_ru;
            $test->description_kg = $descript_kg;
            $test->description_ru = $descript_ru;
            //$test->user_id =\Auth::id();
            $test->update();                
            $settings->quest_random = $quest_random;
            $settings->quest_count = $quest_count_num;
            $settings->answer_random = $answer_random;
            $settings->duration = $duration;
            $settings->test_id = $test->id;
            $settings->update();
        }
        return redirect()->to("/admin/test/list");        
    }
    public function TestList()
    {
        return view("admin.list_test");
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
    public function tests(Request $request, $id)
    {
        $tsting = Tsting::where("_id", $id)->first();
        $test = Test::where("id",  $tsting->id)->with(["Question.Answers"])->first();
        $setting = Settings::where('test_id', $test->id)->first();
        return ["settings"=>$setting, "test"=>$test];
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
            $quest = Question::where("test_id", $test->id)->orderBy(DB::raw('RAND()'))->take($settings->quest_count)->with('Answers')->get();
        }else{
            $quest = Question::where("test_id", "=", $test->id)->get();
        }
        $ret = [
            "id"=>$test->id,
            "name_ru"=>$test->name_ru,
            "description"=>$test->descript_ru,
            "enable"=>$test->enable,
            "user_id"=>$test->_id,
            'question'=> $quest
            
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
