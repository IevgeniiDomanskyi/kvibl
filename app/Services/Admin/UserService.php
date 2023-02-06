<?php

namespace App\Services\Admin;

use App\Services\Service;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class UserService extends Service
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        return $this->userRepository->all();
    }
}
