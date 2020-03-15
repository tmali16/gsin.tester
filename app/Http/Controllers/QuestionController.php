<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $data = $request->datas;        
        $test_user = Tsting::where("test_id", $test_id)->first();
        foreach ($data as $key => $value) {
            dd($value);
        }
        $cur = $test_user->answers;
        if(strlen($cur) <= 3){
            $test_user->answers = json_encode($tst, JSON_PRETTY_PRINT);
            $test_user->update();
        }else{
            $cur = json_decode($test_user->answers, true);
        }

        return collect($cur);
    }

    public function addAnswer(Request $request)
    {
        $data = session()->get('test');
        // $data = $request->session()->all();
        dd($data);
    }

}
