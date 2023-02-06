<?php

namespace App\Services\Admin;

use App\Services\Service;
use App\Repositories\WordRepository;
use Carbon\Carbon;

class WordService extends Service
{
    protected $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    public function getByValue($value, $lang_id)
    {
        return $this->wordRepository->getByValue($value, $lang_id);
    }

    public function all($category_id)
    {
        return $this->wordRepository->all($category_id);
    }
    
    public function add($data)
    {
        $is_exist = $this->getByValue($data['value'], $data['lang_id']);

        if ( ! $is_exist) {
            $data['value'] = ucfirst($data['value']);

            // Add word to the database
            $word = $this->wordRepository->add($data);
            
            // Add word to pivot table
            $word->categories()->syncWithoutDetaching($data['category_id']);
        }
    }
    
    public function update($data)
    {
        $word_data = [
            'value' => $data['value'],
            'is_active' => $data['is_active'],
        ];
        return $this->wordRepository->update($data['id'], $word_data);
    }
    
    public function delete($data)
    {
        foreach ($data as $id) {
            $word = $this->wordRepository->get($id);

            if ( ! empty($word->categories())) {
                $word->categories()->detach();
            }
            
            $this->wordRepository->delete($id);
        }
    }
    
    public function reset($category_id)
    {
        $this->wordRepository->reset($category_id);
        // $words = $this->all($category_id);
        // $words->update([
        //     'count_show' => 0,
        //     'count_success' => 0,
        // ]);
    }
}
