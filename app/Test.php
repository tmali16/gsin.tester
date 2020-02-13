<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    
    public function Question()
    {
        return $this->hasMany("App\Question");
    }
    public function Settings()
    {
        return $this->hasOne("App\Settings");
    }
}
