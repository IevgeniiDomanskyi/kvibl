<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\ColorRepository;
use App\Color;
use App\Game;

class ColorService extends Service
{
    protected $colorRepository;

    public function __construct(colorRepository $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    //Get random color
    public function randomColor($ids) {
        $color = $this->colorRepository->getRandom($ids);
        return $color;
    }
}
