<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    const DAYS_TO_CLEAR = 3;
    const STATUS_PENDING = 0;
    const STATUS_MAIN = 1;
    const STATUS_PREPARE = 2;
    const STATUS_ROUND = 3;
    const STATUS_WORDS_CONFIRM = 4;
    const STATUS_AWARDS = 5;
    const STATUS_FINISHED = 6;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash', 'code', 'status', 'lap', 'current_team_id', 'complete', 'round_at'
    ];

    protected $attributes = [
        'status' => 0,
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'players')->withPivot('id', 'hash', 'name', 'score', 'is_disabled', 'is_online', 'is_owner');
    }

    public function players()
    {
        return $this->hasMany('App\Player')->orderBy('team_id')->orderBy('position');
    }

    public function captains()
    {
        return $this->hasMany('App\Player')->where('is_captain', true)->orderBy('team_id');
    }

    public function teams()
    {
        return $this->hasMany('App\Team')->orderBy('position');
    }

    public function words()
    {
        return $this->belongsToMany('App\Word', 'player_word')->withPivot('is_approved', 'is_current', 'lap');
    }

    public function confirms()
    {
        return $this->belongsToMany('App\Word', 'confirm_word')->withPivot('player_id', 'is_owner', 'is_approved', 'is_finished');
    }

    public function getRouteKeyName()
    {
        return 'hash';
    }

    public function currentTeam()
    {
        return $this->teams()->where('id', $this->current_team_id)->first();
    }

    public function currentTeamCaptain()
    {
        return $this->players()->where('team_id', $this->current_team_id)->where('is_captain', true)->first();
    }

    public function currentPlayer()
    {
        return $this->players()->where('id', $this->currentTeam()->current_player_id)->first();
    }

    public function currentWords()
    {
        return $this->currentPlayer()->words()->where('game_id', $this->id)->where('lap', $this->lap)->get();
    }
}
