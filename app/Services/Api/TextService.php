<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Locale;

class TextService extends Service
{
    protected $defaultPath = '';

    public function __construct()
    {
        $this->defaultPath = resource_path().'/lang_default/';
    }

    public function get(Locale $locale)
    {
        if (empty($locale->code)) {
            if (auth()->check()) {
                $locale = auth()->user()->locale;
            } else {
                $locale = service('Api\Locale')->getDefault();
            }
        }

        $default = $this->_read();

        $path = resource_path().'/lang/'.$locale->code.'/';
        $text = $this->_read($path);

        $result[$locale->code] = array_replace_recursive($default, $text);

        return $result;
    }

    public function all()
    {
        $me = auth()->user();
        $this->throwIfNotSuperadmin($me);

        $locales = $this->localeService->all();

        $default = $this->_read();

        $result = [];
        foreach ($locales as $locale) {
            $path = resource_path().'/lang/'.$locale->code.'/';
            $text = $this->_read($path);

            $result[$locale->code] = array_replace_recursive($default, $text);
        }

        return $result;
    }

    protected function _read($path = null)
    {
        if (empty($path)) {
            $path = $this->defaultPath;
        }

        $result = [];
        if (file_exists($path)) {
            $files = array_values(array_diff(scandir($path), array('.', '..')));
            foreach ($files as $file) {
                $temp = [];
                $temp[str_replace('.php', '', $file)] = include($path.$file);
                $result = array_merge($result, $temp);
            }
        }

        return $result;
    }
}
