<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLangIdInFakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fakers', function (Blueprint $table) {
            $table->renameColumn('lang_id', 'locale_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fakers', function (Blueprint $table) {
            $table->renameColumn('locale_id', 'lang_id');
        });
    }
}
