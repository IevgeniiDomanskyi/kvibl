<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function words()
    {
        return $this->belongsToMany('App\Word', 'category_word', 'category_id', 'word_id');
    }
    
    public function locales()
    {
        return $this->belongsToMany('App\Locale', 'category_locale', 'category_id', 'locale_id')->withPivot('name', 'description');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'category_user', 'category_id', 'user_id')->withPivot('lang_id');
    }
}
