<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Word;
use App\Game;
use App\Player;
use DB;

class WordRepository
{

    public function get($id)
    {
        return Word::where('id', $id)->with('categories')->first();
    }

    public function getByValue($value, $lang_id)
    {
        return Word::where('value', $value)->where('lang_id', $lang_id)->first();
    }

    public function all($category_id)
    {
        return Word::whereHas('categories', function($q) use ($category_id) {
            $q->where('category_word.category_id', $category_id);
        })->get();
    }

    public function add($data)
    {
        return Word::create([
            'value' => $data['value'],
            'lang_id' => $data['lang_id'],
            'is_active' => $data['is_active'],
        ]);
    }

    public function update($id, $data)
    {
        $word = Word::find($id);
        $word->update($data);
        return $word;
    }

    public function delete($id)
    {
        Word::find($id)->delete();
    }

    public function reset($category_id)
    {
        Word::whereHas('categories', function($q) use ($category_id) {
            $q->where('category_word.category_id', $category_id);
        })->where('count_show', '!=', 0)->orWhere('count_success', '!=', 0)->update([
            'count_show' => 0,
            'count_success' => 0,
        ]);
    }

    public function getRandom($approved_ids, $exist_ids)
    {
        $words = Word::where('is_active', true)->whereNotIn('id', $exist_ids)->take(10)->inRandomOrder()->get();
        if (!$words || $words->count() != 10) {
            $words = Word::where('is_active', true)->whereNotIn('id', $approved_ids)->take(10)->inRandomOrder()->get();
            if (!$words || $words->count() != 10) {
                $words = Word::where('is_active', true)->take(10)->inRandomOrder()->get();
            }
        }

        return $words;
    }

    public function increaseSuccess(Word $word)
    {
        $word->update(['count_success'=> DB::raw('count_success+1')]);
        return $word;
    }

    public function increaseShow(Word $word)
    {
        $word->update(['count_show'=> DB::raw('count_show+1')]);
        return $word;
    }

    public function setCurrent(Game $game, Player $player, Word $word)
    {
        $word->players()->wherePivot('game_id', $game->id)->wherePivot('lap', $game->lap)->updateExistingPivot($player, array('is_current' => true), false);
        return $word;
    }
}
