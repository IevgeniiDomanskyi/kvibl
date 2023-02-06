<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'player_action';

    protected $guarded = [];

    protected $fillable = [
        'player_id', 'action', 'value',
    ];

    public function player()
    {
        return $this->belongsTo('App\Player');
    }
}
