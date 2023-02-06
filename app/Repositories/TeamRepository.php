<?php

namespace App\Repositories;

use App\Team;

class TeamRepository
{
    public function create()
    {
        return Team::create();
    }

    public function update(Team $team, array $data)
    {
        $team->fill($data);
        $team->save();
        return $team;
    }
}
