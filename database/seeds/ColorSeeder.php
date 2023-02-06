<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->truncate();
        $colors = ['#F34336', '#E81E63', '#9C27B0', '#3F51B5', '#03A8F3', '#009587', '#8BC34A', '#FEEA3B', '#FF9800', '#607D8A'];
        foreach ($colors as $code) {
            $color = new Color;
            $color->code = $code;
            $color->save();
        }
    }
}
