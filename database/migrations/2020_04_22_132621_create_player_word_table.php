<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_word', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_id')->default(0);
            $table->bigInteger('player_id')->default(0);
            $table->bigInteger('word_id')->default(0);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_current')->default(false);
            $table->unsignedTinyInteger('lap')->default(1);
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
        Schema::dropIfExists('player_word');
    }
}
