<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tsting;


class IndexController extends Controller
{
    
    public function Index()
    {
       return view('index.index', []);
    }

    public function chckUser(Request $request)
    {

        if(Tsting::where('_id', $request->id)->count() != 0){
            return redirect("/welcome/$request->id");
        }else{
            $ret = [
                "message"=>"Данный тестируемый не найден"
            ];
            return redirect("/")->withErrors($ret);
        }
    }
    public function welcome(Request $request, $id)
    {
        $testing  = Tsting::where("_id", $id)->with(["test.Settings", "test.user"])->first();
        $fullname = $testing->fn . " " . $testing->mn . " " . $testing->ln;
        
        return view("index.welcome", ["name"=>$fullname, "testing"=>$testing]);
    }
}
