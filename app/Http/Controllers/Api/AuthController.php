<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\PreRegister as AuthPreRegisterRequest;
use App\Http\Requests\Api\Auth\Recovery as AuthRecoveryRequest;
use App\Http\Requests\Api\Auth\Login as AuthLoginRequest;
use App\Http\Requests\Api\Auth\Password as AuthPasswordRequest;
use App\Http\Resources\Api\User\Me as UserMeResourse;
use App\Game;
use App\Player;
use App\Hash;

class AuthController extends Controller
{
    public function pre_register(AuthPreRegisterRequest $request)
    {
        $data = $request->only('locale');
        $result = service('Api\Auth')->pre_register($data);
        return response()->result(new UserMeResourse($result));
    }

    public function me(Request $request)
    {
        $data = $request->only('app_id', 'email', 'name', 'photo');
        $result = service('Api\Auth')->me($data);
        return response()->result(new UserMeResourse($result));
    }

    public function login(Game $game, Player $player, AuthLoginRequest $request)
    {
        $data = $request->only(['email', 'password']);
        $result = service('Api\Auth')->login($game, $player, $data);
        return response()->result(new UserMeResourse($result));
    }

    public function logout(Game $game, Player $player)
    {
        $result = service('Api\Auth')->logout($game, $player);
        return response()->result(new UserMeResourse($result));
    }

    public function recovery(AuthRecoveryRequest $request)
    {
        $data = $request->only(['email', 'link']);
        $result = service('Api\Auth')->recovery($data['email'], $data['link']);

        return response()->result($result);
    }

    public function password(Hash $hash, AuthPasswordRequest $request)
    {
        $data = $request->only(['password']);
        $result = service('Api\Auth')->password($hash, $data['password']);

        return response()->result(new UserMeResourse($result));
    }

    public function hash(Hash $hash)
    {
        $result = service('Api\Auth')->hash($hash);

        return response()->result(new UserMeResourse($result));
    }

    public function activate(Hash $hash)
    {
        $result = service('Api\Auth')->activate($hash);

        return response()->result(new UserMeResourse($result));
    }
}
