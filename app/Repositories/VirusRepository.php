<?php

namespace App\Repositories;

use App\Virus;
use App\Game;
use App\Player;
use DB;

class VirusRepository
{
    public function all()
    {
        return Virus::all();
    }

    public function get($id)
    {
        return Virus::where('id', $id)->first();
    }

    public function random()
    {
        return Virus::inRandomOrder()->first();
    }
}
