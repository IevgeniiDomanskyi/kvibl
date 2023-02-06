<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\CategoryRepository;
use App\Category;

class CategoryService extends Service
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function all()
    {
        return $this->categoryRepository->all();
    }

    public function allActive()
    {
        return $this->categoryRepository->allActive();
    }

    public function assign($category, $lang)
    {
        $me = auth()->user();
        $this->categoryRepository->assign($category, $lang, $me);
        return $category;
    }
}
