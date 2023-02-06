<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id', 'color_id', 'position', 'current_player_id', 'score', 'name', 'color', 'is_owner', 'is_winner',
    ];

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function color()
    {
        return $this->belongsTo('App\Color');
    }

    public function players()
    {
        return $this->hasMany('App\Player');
    }

    public function currentPlayer()
    {
        return $this->players()->where('id', $this->current_player_id)->first();
    }
}
