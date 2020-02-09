<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quest_count')->unsigned()->nullable()->default(0);
            $table->tinyInteger('quest_random')->unsigned()->default(0);
            $table->tinyInteger('answer_random')->unsigned()->default(0);
            $table->integer('duration')->unsigned()->nullable()->default(0);
            $table->bigInteger('test_id')->unsigned()->index();
            $table->timestamps();
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->foreign('test_id')->references('id')->on('tests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
