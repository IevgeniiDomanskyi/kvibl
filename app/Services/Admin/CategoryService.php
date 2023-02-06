<?php

namespace App\Services\Admin;

use App\Services\Service;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CategoryRepository;

class CategoryService extends Service
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->wordsService = service('Admin\Word');
        $this->localeService = service('Admin\Locale');
        $this->langService = service('Admin\Lang');
    }

    public function all()
    {
        return $this->categoryRepository->all();
    }

    public function get($id)
    {
        return $this->categoryRepository->get($id);
    }

    public function add($data)
    {
        $isExist = true;
        $data['name'] = array_filter($data['name'], 'strlen');
        $data['description'] = array_filter($data['description'], 'strlen');
        $category_data = [
            'is_active' => $data['is_active'],
            'is_free' => $data['is_free'],
            'cover_image' => '',
            //'cover_image' => $data['cover_image']['name'],
        ];
        $pivot_data = [];

        foreach($data['name'] as $key => $name) {
            $tempArr = [];
            $tempArr['locale_id'] = $key;
            $tempArr['name'] = $name;
            $tempArr['description'] = $data['description'][$key];
            $key == 1 ? $isExist = $this->getByName($name, $key) : $isExist;
            array_push($pivot_data, $tempArr);
        }

        if ( ! $isExist) {
            //return $this->create($category_data, $pivot_data, $data['cover_image']);
            return $this->create($category_data, $pivot_data);
        }

        return false;
    }

    public function getByName($name, $locale_id)
    {
        return $this->categoryRepository->getByName($name, $locale_id);
    }

    public function create($category_data, $pivot_data, $cover_image = '')
    {
        // Creating actual record of category
        $category = $this->categoryRepository->create($category_data);

        //$path = $this->uploadImage($cover_image, $category['id']);

        // Create record in category_locale pivot table with name and description of category
        foreach($pivot_data as $pivot) {
            $category->locales()->attach($pivot['locale_id'], [
                'name' => $pivot['name'],
                'description' => $pivot['description'],
            ]);
        }

        return $category;
    }

    public function delete($data)
    {
        foreach ($data as $id) {
            $category = $this->categoryRepository->get($id);

            if ( ! empty($category->words())) {
                $category->words()->detach();
            }

            $category->locales()->detach();

            $this->categoryRepository->delete($id);
        }
    }

    public function upload($file)
    {
        $path = '';
        if ($file->file) {
            $path = $file->file->storeAs('uploads', 'import_categories.kvb');
        }

        return Storage::url($path);
    }

    public function uploadImage($file, $category_id)
    {
        $path = '';
        if ($file) {
            $path = $file->storeAs('uploads/categories/'. $category_id, $file->name);
        }

        return Storage::url($path);
    }

    public function import($data)
    {
        $content = file_get_contents($data);
        $data = json_decode($content);

        foreach ($data as $item) {
            $pivot_data = [];

            foreach($item->name as $key => $row) {
                $category_result = $this->getByName($row, $key); // Find category by it's name
            }

            // Check if category is already exists
            if (empty($category_result)) {
                // Making the array of category data
                $category_data = [
                    'is_active' => $item->is_active,
                    'is_free' => $item->is_free,
                ];

                foreach($item->name as $key => $name) {
                    $tempArr = [];
                    $tempArr['locale_id'] = $key;
                    $tempArr['name'] = $name;
                    $tempArr['description'] = $item->description->$key;
                    array_push($pivot_data, $tempArr);
                }

                // Pass the data to service which will handle creating of new category
                $category = $this->create($category_data, $pivot_data);
                $category_id = $category->id;
            } else {
                // Assign category id to the variable to use it when store the words
                $category_id = $category_result->id;
            }

            // Store words to database
            foreach ($item->words as $word) {
                $lang_info = $this->langService->getByCode($word->lang_code); // get Lang resource by lang code from imported array of data
                $lang_id = $lang_info->id;

                $word_result = $this->wordsService->getByValue($word->value, $lang_id); // find the word in database

                if ( ! empty($word_result)) { // check if word is exist in database
                    $needToSave = true;
                    $caregory_exists = $word_result->categories()->where('category_id', $category_id)->exists(); // check if word is already have relation with current category

                    if ($caregory_exists) {
                        $needToSave = false;
                    }

                    if ($needToSave) {
                        $word_result->categories()->attach($category_id);
                    }
                } else {
                    // Making the array of word data
                    $word_data = [
                        'value' => $word->value,
                        'lang_id' => $lang_id,
                        'is_active' => $word->is_active,
                        'category_id' => $category_id,
                    ];

                    // Add the word to the database
                    $word = $this->wordsService->add($word_data);
                }
            }
        }
    }

    public function export()
    {
        $export = [];
        $all_cats = $this->all(); // get all categories
        $this->removeOldFile(); // remove old file with exported data

        foreach ($all_cats as $item) {
            $category = [];
            $words = [];
            $locale_pivot = $item->locales()->where('category_id', $item->id)->get();
            $word_pivot = $item->words()->where('category_id', $item->id)->get();
            $tempNames = [];
            $tempDescriptions = [];

            foreach($locale_pivot as $row) {
                $tempNames[$row['id']] = $row->pivot->name;
                $tempDescriptions[$row['id']] = $row->pivot->description;
            }

            $category['name'] = $tempNames;
            $category['description'] = $tempDescriptions;

            //$category->localeCode = $this->localeService->get($locale_pivot->id)->code;
            $category['is_active'] = $item->is_active;
            $category['is_free'] = $item->is_free;

            foreach ($word_pivot as $row) {
                $word = (object)[];
                $word->value = $row->value;
                $word->lang_code = $this->langService->get($row->lang_id)->code;
                $word->is_active = $row->is_active;
                array_push($words, $word);
            }

            $category['words'] = $words;
            array_push($export, $category);
        }

        file_put_contents('storage/categories.kvb', json_encode($export));
    }

    public function removeOldFile()
    {
        $file = 'storage/categories.kvb';
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
