<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Register as UserRegisterRequest;
use App\Http\Requests\Api\User\Settings as UserSettingsRequest;
use App\Http\Resources\Api\User\Me as UserMeResourse;
use App\Game;
use App\Player;

class UserController extends Controller
{
    public function register(Game $game, Player $player, UserRegisterRequest $request)
    {
        $data = $request->only('app_id', 'email', 'password', 'locale', 'is_registered', 'name', 'photo', 'avatar', 'link');
        $result = service('Api\User')->register($game, $player, $data);
        return response()->result(new UserMeResourse($result));
    }

    public function settings(UserSettingsRequest $request)
    {
        $data = $request->only('field', 'value');
        $result = service('Api\User')->settings($data);
        return response()->result(new UserMeResourse($result));
    }
}
