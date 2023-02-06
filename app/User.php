<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id', 'locale_id', 'name', 'avatar', 'email', 'password', 'is_registered', 'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function locale()
    {
        return $this->belongsTo('App\Locale');
    }

    public function games()
    {
        return $this->belongsToMany('App\Game', 'players');
    }

    public function isMe()
    {
        return $this->id == auth()->id();
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_user', 'user_id', 'category_id')->withPivot('lang_id');
    }

    public function hashes()
    {
        return $this->morphToMany('App\Hash', 'hashable')->withTimestamps();
    }
}
