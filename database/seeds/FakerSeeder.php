<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Faker;
use App\Locale;

class FakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fakers')->truncate();

        $fakers = [
            [
                'text' => 'Альфа',
                'code' => 'ua',
            ],
            [
                'text' => 'Бета',
                'code' => 'ua',
            ],
            [
                'text' => 'Гамма',
                'code' => 'ua',
            ],
            [
                'text' => 'Дельта',
                'code' => 'ua',
            ],
            [
                'text' => 'Омега',
                'code' => 'ua',
            ],
            [
                'text' => 'Сігма',
                'code' => 'ua',
            ],
            [
                'text' => 'Каппа',
                'code' => 'ua',
            ],
            [
                'text' => 'Альфа',
                'code' => 'ru',
            ],
            [
                'text' => 'Бета',
                'code' => 'ru',
            ],
            [
                'text' => 'Гамма',
                'code' => 'ru',
            ],
            [
                'text' => 'Дельта',
                'code' => 'ru',
            ],
            [
                'text' => 'Омега',
                'code' => 'ru',
            ],
            [
                'text' => 'Сигма',
                'code' => 'ru',
            ],
            [
                'text' => 'Каппа',
                'code' => 'ru',
            ],
            [
                'text' => 'Alpha',
                'code' => 'en',
            ],
            [
                'text' => 'Beta',
                'code' => 'en',
            ],
            [
                'text' => 'Gamma',
                'code' => 'en',
            ],
            [
                'text' => 'Delta',
                'code' => 'en',
            ],
            [
                'text' => 'Omega',
                'code' => 'en',
            ],
            [
                'text' => 'Sigma',
                'code' => 'en',
            ],
            [
                'text' => 'Kappa',
                'code' => 'en',
            ],
        ];

        foreach ($fakers as $f) {
            $locale = Locale::where('code', $f['code'])->first();
            $faker = new Faker;
            $faker->text = $f['text'];
            $faker->locale_id = $locale->id;
            $faker->save();
        }
    }
}
