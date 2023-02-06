<?php

namespace App\Repositories;

use App\Faker;

class FakerRepository
{
    public function random($names, $locale_id)
    {
        $fake = Faker::where('locale_id', $locale_id)->whereNotIn('text', $names)->inRandomOrder()->first();
        if (empty($fake)) {
            Faker::inRandomOrder()->first();
        }
        return $fake;
    }
}
