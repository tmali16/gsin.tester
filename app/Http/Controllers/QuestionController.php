<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use App\Tsting;


class QuestionController extends Controller
{
    //

    public function Newquestion(Request $request)
    {
        $rules = [
            "question_ru" => "required|min:2",
            "question_kg" => "required|min:2",
        ];
        if($this->validate($request, $rules, [])){
            $quest = new Question();
            
            $ans = $request->answers;
            $quest->test_id = $request->test_id;
            $quest->type_id = 1;
            $quest->question_ru = $request->question_ru;
            $quest->question_kg = $request->question_kg;
            if($quest->save()){      
                foreach ($ans as $key => $value) {
                    $answer = new Answer();
                    $answer->answer = $value['answer'];
                    $answer->right = ($value['right'] == true ? 1 : 0);
                    $answer->answer_id = $quest->id;
                    $answer->save();
                }
            }
        }
        return response()->json(array(
                                "status" => "ok",
                                "message" =>"Добвлено"
                            ));
    }

    public function store(Request $request, $id)
    {
        $data = $request->answer;
        $start_date = $request->session()->get("start_time");
        $end_time = date("H:i:s");
        $test_user = Tsting::where("test_id", $id)->first();
        $test = $test_user->test;
        $point = 0;
        $store_data = [
            "test"=> $test->name_kg, 
            "full name"=> $test_user->fn . " " . $test_user->mn . " " . $test_user->ln,
            "start"=>$start_date,
            "end"=>date("H:i:s"),
            "date"=>date("d.m.Y"),
            "duration"=> $this->duration($start_date, $end_time),
            "code"=> $test_user->_id,
            "test"=>[]];
        foreach ($data as $key => $value) {
            $q_id = $value["question_id"];
            $a_id = $value["answer_id"];
            $answer = Answer::where("id", $a_id)->where("answer_id", $q_id)->first();
            if($answer->right == 1){
                $point = $point + 1;
            }
            $s_j = array("answer"=>$answer->answer, "question"=> $answer->question->question_ru, "right"=>$answer->right);
            $store_data["test"][] = $s_j;
        }
        $store_data["right"]= $point;
        $store_data["wrong"]= count($data) - $point;
        $cur = $test_user->answers;
        if($point > 0){
            $test_user->point = $point;
            $test_user->answers = json_encode($store_data);
            $test_user->update();
        }

        return redirect("/report/$test_user->_id");
    }

    public function addAnswer(Request $request)
    {
        $data = session()->get('test');
        // $data = $request->session()->all();
        dd($data);
    }
    function duration($st, $e){
        $start = Carbon::parse($st);
        $end = Carbon::parse($e);
        $minute = $end->diffInMinutes($start);
        return $minute;
    }
    public function report_test(Request $request, $id)
    {
        $user_id = $id;
        $user = Tsting::where("_id", $user_id)->first();
        return view("index.report", ["data"=>json_decode($user->answers, true)]);
    }

}
