<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tsting extends Model
{
    //

    public function test()
    {
        return $this->hasOne("App\Test", "id", "test_id");
    }
}
