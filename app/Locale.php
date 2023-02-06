<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_locale', 'locale_id', 'category_id')->withPivot('name', 'description');
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}
