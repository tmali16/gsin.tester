<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tsting;

class AnswerController extends Controller
{
    
    public function putAnswerUser(Request $requset)
    {
        $test_id = $requset->id;
        $question_id = $requset->question_id;
        $answer_id = $requset->answer_id;
        
        $answer = Answer::find($answer_id);
        
        $testing = new Tsting();

        if($answer != null){
            
        }

    }
}
