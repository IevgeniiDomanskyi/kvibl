<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('game_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->string('name')->default('');
            $table->unsignedTinyInteger('score')->default(0);
            $table->boolean('disabled')->default(false);
            $table->boolean('ready')->default(false);
            $table->boolean('owner')->default(false);
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
        Schema::dropIfExists('players');
    }
}
