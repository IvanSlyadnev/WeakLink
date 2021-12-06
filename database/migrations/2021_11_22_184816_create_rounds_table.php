<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->integer('current_money')->default(0);
            $table->integer('bank')->default(0);
            $table->bigInteger('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->bigInteger('strong_link')->unsigned()->nullable();
            $table->foreign('strong_link')->references('id')->on('users')->onDelete('set null');
            $table->bigInteger('weak_link')->unsigned()->nullable();
            $table->foreign('weak_link')->references('id')->on('users')->onDelete('set null');
            $table->bigInteger('dead')->unsigned()->nullable();
            $table->foreign('dead')->references('id')->on('users')->onDelete('set null');
            $table->boolean('is_final')->default(false);
            $table->boolean('finished')->default(false);
            $table->integer('seria')->default(0);
            $table->bigInteger('current_user_id')->nullable()->unsigned();
            $table->foreign('current_user_id')->references('id')->on('users');
            $table->bigInteger('current_question_id')->nullable()->unsigned();
            $table->foreign('current_question_id')->references('id')->on('questions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rounds');
    }
}
