<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    const STATUS_NEW = 0;
    const STATUS_PLAYER = 1;
    const STATUS_SPECTATOR = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'team_id', 'color_id', 'hash', 'name', 'score', 'status', 'tab', 'position', 'is_disabled', 'is_online', 'is_owner', 'is_captain', 'is_approved',
    ];

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function color()
    {
        return $this->belongsTo('App\Color');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function actions()
    {
        return $this->hasMany('App\Action');
    }

    public function words()
    {
        return $this->belongsToMany('App\Word')->withPivot('game_id', 'is_approved', 'is_current', 'lap', 'word_id', 'virus_id', 'virus_player_id');
    }

    public function viruses()
    {
        return $this->belongsToMany('App\Virus')->withPivot('id', 'owner_id');
    }

    public function viruses_bag()
    {
        return $this->morphedByMany('App\Virus', 'bagable')->withPivot('count');
    }

    public function confirms()
    {
        return $this->belongsToMany('App\Word', 'confirm_word')->withPivot('is_owner', 'is_approved', 'is_finished')->withTimestamps();
    }

    public function getRouteKeyName()
    {
        return 'hash';
    }
}
