<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use App\User;

trait TestInit
{
    /**
    * If true, setup has run at least once.
    * @var boolean
    */
    protected static $setUpHasRunOnce = false;
    protected static $currentGame = false;
    protected static $currentUser = false;
    protected static $currentPlayer = false;

    protected $api;

    /**
    * After the first run of setUp "migrate:fresh --seed"
    * @return void
    */
    public function setUp(): void
    {
        parent::setUp();

        $this->api = 'api/v1/';

        if ( ! static::$setUpHasRunOnce) {
            Artisan::call('migrate:fresh --seed');
            //static::$setUpHasRunOnce = true;
        }
    }

    public function auth()
    {
        static::$currentUser = $user = factory(User::class)->create(['locale_id' => 1]);
        $user->token = $user->createToken($user->email)->plainTextToken;
        
        return $user;
    }

    public function jsonAuth($method, $url, $data = [])
    {
        $user = $this->auth();

        Sanctum::actingAs($user, ['*']);

        return $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token,
        ])->json($method, $url, $data);
    }

    public function jsonUser($method, $url, $data = [])
    {
        $user = static::$currentUser;

        Sanctum::actingAs($user, ['*']);

        return $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token,
        ])->json($method, $url, $data);
    }

    public function createGame()
    {
        return $this->jsonAuth('POST', $this->api.'game');
    }

    public function connectGame()
    {
        return $this->jsonAuth('POST', $this->api.'game/connect', ['code' => static::$currentGame['code']]);
    }

    public function connectNewGame()
    {
        $responce = $this->createGame()->decodeResponseJson();
        static::$currentGame = $responce['data'];
        return $this->jsonAuth('POST', $this->api.'game/connect', ['code' => $responce['data']['code']]);
    }

    public function connectCurrentGame()
    {
        return $this->jsonAuth('POST', $this->api.'game/connect', ['code' => static::$currentGame['code']]);
    }

    //Start game
    public function startGame()
    {
        $responce = $this->createGame()->decodeResponseJson();
        static::$currentGame = $responce['data'];
        $user = static::$currentUser;

        $this->playerSetCurrent();
        $responce = $this->playerCurrentRename(['status' => 1, 'name' => 'Player owner'])->decodeResponseJson();

        $responce = $this->connectCurrentGame()->decodeResponseJson();
        $this->playerSetCurrent();
        $responce = $this->playerCurrentRename(['status' => 1, 'name' => 'Player 2'])->decodeResponseJson();

        $responce = $this->connectCurrentGame()->decodeResponseJson();
        $this->playerSetCurrent();
        $responce = $this->playerCurrentRename(['status' => 1, 'name' => 'Player 3'])->decodeResponseJson();

        $responce = $this->connectCurrentGame()->decodeResponseJson();
        $this->playerSetCurrent();
        $responce = $this->playerCurrentRename(['status' => 1, 'name' => 'Player 4'])->decodeResponseJson();

        $responce = $this->connectCurrentGame()->decodeResponseJson();
        $this->playerSetCurrent();
        $responce = $this->playerCurrentRename(['status' => 1, 'name' => 'Player 5'])->decodeResponseJson();

        static::$currentUser = $user;

        return $this->jsonUser('POST', $this->api.'game/'.static::$currentGame['hash'].'/start', ['teams' => 2]);
    }

    //Start game
    public function startGameWithTeams()
    {
        $responce = $this->createGame()->decodeResponseJson();
        static::$currentGame = $responce['data'];
        $user = static::$currentUser;
        $teams = [[], []];

        $this->playerSetCurrent();
        $responce = $this->playerCurrentRename(['status' => 1, 'name' => 'Player owner'])->decodeResponseJson();
        $teams[0][] = static::$currentUser['id'];

        $responce = $this->connectCurrentGame()->decodeResponseJson();
        $this->playerSetCurrent();
        $responce = $this->playerCurrentRename(['status' => 1, 'name' => 'Player 2'])->decodeResponseJson();
        $teams[0][] = static::$currentUser['id'];

        $responce = $this->connectCurrentGame()->decodeResponseJson();
        $this->playerSetCurrent();
        $responce = $this->playerCurrentRename(['status' => 1, 'name' => 'Player 3'])->decodeResponseJson();
        $teams[1][] = static::$currentUser['id'];

        $responce = $this->connectCurrentGame()->decodeResponseJson();
        $this->playerSetCurrent();
        $responce = $this->playerCurrentRename(['status' => 1, 'name' => 'Player 4'])->decodeResponseJson();
        $teams[1][] = static::$currentUser['id'];

        $responce = $this->connectCurrentGame()->decodeResponseJson();
        $this->playerSetCurrent();
        $responce = $this->playerCurrentRename(['status' => 1, 'name' => 'Player 5'])->decodeResponseJson();
        $teams[1][] = static::$currentUser['id'];

        static::$currentUser = $user;

        return $this->jsonUser('POST', $this->api.'game/'.static::$currentGame['hash'].'/start', ['teams' => 2, 'sorted_teams' => $teams]);
    }

    public function playerGet()
    {
        $responce = $this->connectNewGame()->decodeResponseJson();
        return $this->jsonUser('GET', $this->api.'game/'.static::$currentGame['hash'].'/player/');
    }

    //Get all players for current game
    public function playerCurrentGet()
    {
        return $this->jsonUser('GET', $this->api.'game/'.static::$currentGame['hash'].'/player/');
    }

    public function playerRename()
    {
        $responce = $this->playerGet()->decodeResponseJson();
        foreach ($responce['data'] as $player) {
            if ($player['user_id'] == static::$currentUser['id']) {
                static::$currentPlayer = $player;
            }
        }

        return $this->jsonUser('POST', $this->api.'game/'.static::$currentGame['hash'].'/player/'.static::$currentPlayer['hash'].'/update', ['status' => 1, 'name' => 'Tester Mikola']);
    }

    //Rename curent player
    public function playerCurrentRename($data)
    {
        return $this->jsonUser('POST', $this->api.'game/'.static::$currentGame['hash'].'/player/'.static::$currentPlayer['hash'].'/update', $data);
    }

    //Set current player for current user
    public function playerSetCurrent()
    {
        $responce = $this->playerCurrentGet()->decodeResponseJson();
        foreach ($responce['data'] as $player) {
            if ($player['user_id'] == static::$currentUser['id']) {
                static::$currentPlayer = $player;
            }
        }
    }

    //Add player to already existed game by owner
    public function playerAdd()
    {
        $responce = $this->startGame()->decodeResponseJson();
        $user = static::$currentUser;
        $this->playerSetCurrent();
        $owner_player = static::$currentPlayer;

        $responce = $this->connectCurrentGame()->decodeResponseJson();
        $responce = $this->playerCurrentRename(['status' => 0, 'name' => 'Player added'])->decodeResponseJson();
        $this->playerSetCurrent();
        
        $added_player = static::$currentPlayer;
        static::$currentUser = $user;

        return $this->jsonUser('POST', $this->api.'game/'.static::$currentGame['hash'].'/player/'.$owner_player['hash'].'/add/'.$added_player['hash'], ['team_id' => 1]);
    }

    //Remove player from game by owner
    public function playerRemove()
    {
        $responce = $this->startGame()->decodeResponseJson();
        $remove_player = static::$currentPlayer;
        $this->playerSetCurrent();
        $owner_player = static::$currentPlayer;

        return $this->jsonUser('DELETE', $this->api.'game/'.static::$currentGame['hash'].'/player/'.$owner_player['hash'].'/remove/'.$remove_player['hash']);
    }
}
