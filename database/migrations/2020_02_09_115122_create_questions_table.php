<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('type_id')->unsigned()->index();
            $table->string('question_kg', 200)->nullable()->default(null);
            $table->string('question_ru', 200)->nullable()->default(null);
            $table->boolean('view')->default(true);
            $table->bigInteger('test_id')->unsigned()->index();
        });
        Schema::table('questions', function (Blueprint $table){
            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('type_id')->references('id')->on('typequestions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
