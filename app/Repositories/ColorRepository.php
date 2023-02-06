<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Color;
use App\Game;

class ColorRepository
{
    public function getRandom($ids)
    {
        $color = Color::whereNotIn('id', $ids)->inRandomOrder()->first();
        if (!$color) {
            $color = Color::inRandomOrder()->first();
        }
        return $color;
    }
}
