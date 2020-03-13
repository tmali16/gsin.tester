<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name_kg");
            $table->string("name_ru");
            $table->string("description_kg", 500)->nullable()->default(null);
            $table->string("description_ru", 500)->nullable()->default(null);
            $table->boolean("enable")->default(false);
            $table->bigInteger('user_id')->unsigned()->index();
            $table->timestamps();
        });
        Schema::table('tests', function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
