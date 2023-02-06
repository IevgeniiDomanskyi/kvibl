<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_word', 'word_id', 'category_id');
    }

    public function players()
    {
        return $this->belongsToMany('App\Player')->withPivot('is_approved', 'is_current', 'lap', 'word_id', 'virus_id', 'virus_player_id');
    }

    public function viruses()
    {
        return $this->belongsToMany('App\Virus', 'player_word')->withPivot('is_approved', 'is_current', 'lap', 'word_id', 'virus_id', 'virus_player_id');
    }

    public function viruses_players()
    {
        return $this->belongsToMany('App\Player', 'player_word', 'word_id', 'virus_player_id')->withPivot('is_approved', 'is_current', 'lap', 'word_id', 'virus_id', 'virus_player_id');
    }

    public function confirms()
    {
        return $this->belongsToMany('App\Player', 'confirm_word')->withPivot('is_owner', 'is_approved', 'is_finished')->withTimestamps();
    }
}
