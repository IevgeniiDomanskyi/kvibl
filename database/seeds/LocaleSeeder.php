<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Locale;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locales')->truncate();

        $locale = new Locale;
        $locale->name = "English";
        $locale->code = "en";
        $locale->default = 1;
        $locale->save();

        $locale = new Locale;
        $locale->name = "Українська";
        $locale->code = "ua";
        $locale->save();

        $locale = new Locale;
        $locale->name = "Русский";
        $locale->code = "ru";
        $locale->save();
    }
}
