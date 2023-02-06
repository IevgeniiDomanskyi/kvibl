<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVirusesIdAndVirusesPlayerIdInPlayerWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('player_word', function (Blueprint $table) {
            $table->integer('virus_id')->after('word_id')->default(0);
            $table->bigInteger('virus_player_id')->after('virus_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_word', function (Blueprint $table) {
            $table->dropColumn('virus_id');
            $table->dropColumn('virus_player_id');
        });
    }
}
