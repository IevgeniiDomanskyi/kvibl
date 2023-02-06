<?php

namespace App\Repositories;

use App\Lang;

class LangRepository
{
    public function all()
    {
        return Lang::all();
    }

    public function get($id)
    {
        return Lang::find($id);
    }

    public function getDefault()
    {
        return Lang::where('default', true)->first();
    }

    public function getByCode($code)
    {
        return Lang::where('code', $code)->first();
    }
}
