<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\WordRepository;
use App\Events\Api\Game\GameChange as GameChangeEvent;
use App\Events\Api\Word\WordChange as WordChangeEvent;
use App\Player;
use App\Game;
use App\Word;

class WordService extends Service
{
    protected $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    //get player words for round
    public function get(Game $game, Player $player)
    {
        if ($game->currentPlayer()->id == $player->id) {
            if ($game->status == Game::STATUS_PREPARE) {
                service('Api\Game')->update($game, ['status' => Game::STATUS_ROUND, 'round_at' => now()]);
                event(new GameChangeEvent($game));
            }
        }

        if ($game->currentPlayer()->id == $player->id) {
            if (count($game->currentWords()) == 0) {
                $approved_ids = $player->words->where('game_id', $game->id)->where('is_approved', true)->pluck('id')->toArray();
                $exist_ids = $game->words->pluck('id')->toArray();

                $words = $this->wordRepository->getRandom($approved_ids, $exist_ids);

                $viruses = $player->viruses;

                foreach ($words as $k => $word) {
                    $words[$k]->lap = $game->lap;
                    $words[$k]->game_id = $game->id;
                    if (!empty($viruses[$k])) {
                        $words[$k]->virus_id = $viruses[$k]->id;
                        $words[$k]->virus_player_id = $viruses[$k]->pivot->owner_id;
                        $player->viruses()->wherePivot('id', $viruses[$k]->pivot->id)->detach();
                    }
                }

                $words = $words->shuffle();

                $current = true;
                foreach ($words as $word) {
                    $player->words()->attach($word, [
                        'is_current' => $current,
                        'lap' => $word->lap,
                        'game_id' => $word->game_id,
                        'virus_id' => !empty($word->virus_id) ? $word->virus_id : 0,
                        'virus_player_id' => !empty($word->virus_player_id) ? $word->virus_player_id : 0,
                        ]);
                    $current = false;
                }
            }
        }

        event(new WordChangeEvent($game));

        return $game->currentWords();
    }

    //Increase counter when word shows for player
    public function view(Game $game, Player $player, Word $word)
    {
        $word = $this->wordRepository->increaseShow($word);
        $player->words()->newPivotStatement()->where('game_id', $game->id)->where('lap', $game->lap)->where('player_id', '=', $player->id)->update(array('is_current' => false));
        $word = $this->wordRepository->setCurrent($game, $player, $word);

        event(new WordChangeEvent($game));

        return $player->words()->where('game_id', $game->id)->where('lap', $game->lap)->where('word_id', $word->id)->first();
    }

    //Aprove player word when it cathed
    public function approve(Game $game, Player $player, Word $word)
    {
        $word->confirms()->detach($player->id);
        $word->confirms()->attach($player->id, ['is_owner' => true, 'is_approved' => true, 'game_id' => $game->id]);

        foreach ($game->captains()->where('id', '<>', $game->currentTeamCaptain()->id)->get() as $cap) {
            $word->confirms()->detach($cap->id);
            $word->confirms()->attach($cap->id, ['is_owner' => false, 'is_approved' => true, 'game_id' => $game->id]);
        }

        event(new WordChangeEvent($game));

        return $player->words()->where('game_id', $game->id)->where('lap', $game->lap)->where('word_id', $word->id)->first();
    }

    //Confirm player word by capitan
    public function confirm(Game $game, Player $player, Word $word, $is_confirm)
    {
        $word->confirms()->detach($player->id);
        $word->confirms()->attach($player->id, ['is_owner' => false, 'is_approved' => $is_confirm, 'game_id' => $game->id]);

        event(new WordChangeEvent($game));

        return true;
    }

    public function increaseSuccess($id)
    {
        $word = $this->wordRepository->get($id);
        if ($word) {
            $word = $this->wordRepository->increaseSuccess($word);
        }
        return $word;
    }
}
