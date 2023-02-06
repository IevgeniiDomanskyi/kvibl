<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LangSeeder::class);
        $this->call(LocaleSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(FakerSeeder::class);
        $this->call(VirusSeeder::class);
    }
}
