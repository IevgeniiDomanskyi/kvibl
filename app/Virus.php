<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Virus extends Model
{
    protected $table = "viruses";

    protected $guarded = [];

    protected $fillable = [
        'name', 'image',
    ];

    public function texts()
    {
        return $this->belongsToMany('App\Locale', 'viruses_texts', 'viruses_id', 'locale_id')->withPivot('name', 'description');
    }

    public function name()
    {
        $locale = service('Api\Locale')->getUserLocale();
        $text = $this->texts()->where('locale_id', $locale->id)->first();
        return !empty($text) ? $text->pivot->name : '';
    }

    public function description()
    {
        $locale = service('Api\Locale')->getUserLocale();
        $text = $this->texts()->where('locale_id', $locale->id)->first();
        return !empty($text) ? $text->pivot->description : '';
    }
}
