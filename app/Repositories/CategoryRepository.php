<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Category;

class CategoryRepository
{
    public function all()
    {
        return Category::with(['locales', 'words'])->get();
    }

    public function allActive()
    {
        return Category::where('is_active', true)->with(['locales', 'words'])->get();
    }

    public function getByName($name, $locale_id)
    {
        return Category::whereHas('locales', function($q) use ($name, $locale_id) {
            $q->where('category_locale.name', $name)->where('category_locale.locale_id', $locale_id);
        })->first();
    }

    public function get($category_id)
    {
        return Category::where('id', $category_id)->with(['locales', 'words'])->first();
    }

    public function create($data)
    {
        return Category::create([
            'is_active' => $data['is_active'],
            'is_free' => $data['is_free'],
            //'cover_image' => $data['cover_image'],
        ]);
    }

    public function delete($id)
    {
        Category::where('id', $id)->delete();
    }

    public function assign($category, $lang, $user) {
        if (!$category->users()->where(['user_id' => $user->id, 'lang_id' => $lang->id])->exists()) {
            $category->users()->attach($user->id, ['lang_id' => $lang->id ]);
        }
    }
}
