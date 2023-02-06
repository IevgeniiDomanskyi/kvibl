<?php

namespace App\Repositories;

use App\Locale;
use Config;

class LocaleRepository
{
    public function all()
    {
        return Locale::all();
    }

    public function get($id)
    {
        return Locale::find($id);
    }

    public function getDefault()
    {
        return Locale::where('default', true)->first();
    }

    public function getByCode($code)
    {
        return Locale::where('code', $code)->first();
    }
}
