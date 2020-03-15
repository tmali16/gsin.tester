<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Tsting;
use App\Test;

class TstingController extends Controller
{
    //

    public function addUser(Request $request)
    {
        $valid = Validator::make($request->all(), [
            "fname"=>"required",
            "mname"=>"required",
            "lname"=>"nullable",
            "test_id" => "required"
        ]);

        if ($valid->fails()) {
            $error = $valid->errors();
            return response()->json(array("status"=> "error", "message"=>$error));
        } 
        $fn = $request->fname;
        $mn = $request->mname;
        $ln = $request->lname;
        $test_id = $request->test_id;

        $ret = "";
        $ret_id = null;
        function ret_id(){
            return rand(000000, 9999999);
        }
        do{
            $ret_id = ret_id();
            if(Tsting::where("id", $ret_id)->count() == 0){
            break;
            }
        }
        while( 0);

        if(Test::where("id", $test_id)->count() > 0){
            $test_user = new Tsting();
            $test_user->fn = $fn;
            $test_user->mn = $mn;
            $test_user->ln = $ln;
            $test_user->test_id = $test_id;
            $test_user->_id = $ret_id;
            $test_user->answers = json_encode(array());
            $test_user->point = 0;
            if($test_user->save()){
                $ret = [
                    "status"=> "ok",
                    "message" => "Теструемый добавлен успешно",
                    "kod" => $ret_id
                ];
            }
        }else{
            $ret = [
                "status" => "error",
                "message" => "Такой тест не найден",
                "kod" => null
            ];
        }
        
        return response()->json($ret);
    }
}
