<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\LocaleRepository;

class LocaleService extends Service
{
    protected $localeRepository;

    public function __construct(LocaleRepository $localeRepository)
    {
        $this->localeRepository = $localeRepository;
    }

    public function all()
    {
        return $this->localeRepository->all();
    }

    public function get($id)
    {
        return $this->localeRepository->get($id);
    }

    public function set($id)
    {
        if (auth()->check()) {
            service('Api\User')->update(auth()->user(), ['locale_id' => $id]);
        }

        return $this->localeRepository->get($id);
    }

    public function getDefault()
    {
        return $this->localeRepository->getDefault();
    }

    public function getByCode($code)
    {
        return $this->localeRepository->getByCode($code);
    }

    public function getUserLocale()
    {
        if (auth()->check()) {
            $locale = auth()->user()->locale;
        } else {
            $locale = $this->getDefault();
        }

        return $locale;
    }
}
