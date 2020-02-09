<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;


class QuestionController extends Controller
{
    //

    public function Newquestion(Request $request)
    {
        $rules = [
            "question" => "required|min:2",
        ];
        if($this->validate($request, $rules, [])){
            $quest = new Question();
            
            $ans = $request->answers;
            $quest->test_id = $request->test_id;
            $quest->type_id = 1;
            $quest->question = $request->question;
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
}
