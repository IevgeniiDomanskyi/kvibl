<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Lang;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('langs')->truncate();

        $lang = new Lang;
        $lang->name = "English";
        $lang->code = "en";
        $lang->default = 1;
        $lang->save();

        $lang = new Lang;
        $lang->name = "Українська";
        $lang->code = "ua";
        $lang->save();

        $lang = new Lang;
        $lang->name = "Русский";
        $lang->code = "ru";
        $lang->save();
    }
}
