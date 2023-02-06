<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bagables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('player_id')->default(0);
            $table->integer('bagable_id')->default(0);
            $table->string('bagable_type')->default('');
            $table->unsignedTinyInteger('count')->default(0);
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
        Schema::dropIfExists('bagables');
    }
}
