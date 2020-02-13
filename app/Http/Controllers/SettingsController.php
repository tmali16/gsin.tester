<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;

class SettingsController extends Controller
{
    //

    public function saveSettings(Request $request)
    {
        $quest_count = $request->quest_count;
        $quest_rand = $request->quest_random;
        $answer_random = $request->answer_random;
        $duration = $request->duration;
        $test_id = $request->test_id;
        $id = $request->id;

        $settings = Settings::where("id", $id)->first();
        $settings->quest_count = $quest_count;
        $settings->quest_random = $quest_rand;
        $settings->answer_random = $answer_random;
        $settings->duration = $duration;

        $settings->save();

        return array("status"=>"ok", "message"=>"Настройки изменены успешно");
    }
}
