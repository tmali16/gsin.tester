<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTstingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tstings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("fn");
            $table->string("mn");
            $table->string("ln")->nullable()->default(null);
            $table->integer("_id");
            $table->json("answers")->default(null);
            $table->boolean("complate")->default(false);
            $table->integer("point")->default(null);
            $table->bigInteger("test_id")->unsigned()->index();
            $table->timestamps();
        });
        Schema::table('tstings', function (Blueprint $table){
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
        Schema::dropIfExists('tstings');
    }
}
