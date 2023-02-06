<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\FakerRepository;
use App\Faker;

class FakerService extends Service
{
    protected $fakerRepository;

    public function __construct(FakerRepository $fakerRepository)
    {
        $this->fakerRepository = $fakerRepository;
    }

    public function getName($names)
    {
        $me = auth()->user();
        $faker = $this->fakerRepository->random($names, $me->locale_id);
        return $faker->text;
    }
}
