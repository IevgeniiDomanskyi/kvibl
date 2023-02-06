<?php

namespace App\Services\Admin;

use App\Services\Service;
use App\Repositories\LangRepository;

class LangService extends Service
{
    protected $langRepository;

    public function __construct(LangRepository $langRepository)
    {
        $this->langRepository = $langRepository;
    }

    public function all()
    {
        return $this->langRepository->all();
    }

    public function get($id)
    {
        return $this->langRepository->get($id);
    }

    public function getDefault()
    {
        return $this->langRepository->getDefault();
    }

    public function getByCode($code)
    {
        return $this->langRepository->getByCode($code);
    }
}
