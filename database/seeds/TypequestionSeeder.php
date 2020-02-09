<?php

use Illuminate\Database\Seeder;
use App\Typequestion;
class TypequestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = ["Выбор правильного ответа"];
        foreach ($type as $key => $value) {
            Typequestion::create(['type' => $value]);
        }
    }
}
