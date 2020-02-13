<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    public $timestamps = false;

    public function Answers()
    {
        return $this->hasMany("App\Answer","answer_id");
    }
}
