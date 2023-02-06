<?php

namespace App\Services\Api;

use App\Services\Service;
use Illuminate\Support\Facades\Hash;
use App\Game;
use App\Player;
use App\Hash as Uhash;

class AuthService extends Service
{
    public function __construct()
    {
        //
    }

    //Register player
    public function pre_register($data)
    {
        $hash = md5(time().rand());
        $locale = false;
        if (!empty($data['locale'])) {
            $locale = service('Api\Locale')->getByCode($data['locale']);
        }

        if (empty($locale))
        {
            $locale = service('Api\Locale')->getDefault();
        }

        $data = [
            'email' => $hash.'@kvibl.com',
            'password' => bcrypt($hash),
            'is_registered' => false,
            'locale_id' => $locale->id,
        ];

        $user = service('Api\User')->create($data);
        $user->token = $user->createToken($user->email)->plainTextToken;

        return $user;
    }

    //Get player info
    public function me($data)
    {
        if (!empty($data['app_id'])) {
            $user = service('Api\User')->getByAppId($data['app_id']);
            if ($user) {
                $user->token = $user->createToken($user->email)->plainTextToken;
                return $user;
            } elseif (!empty($data['email'])) {
                $user = service('Api\User')->getByEmail($data['email']);
                if ($user) {

                    $update_data['app_id'] = $data['app_id'];
                    if (empty($user->name) && !empty($data['name'])) {
                        $update_data['name'] = $data['name'];
                    }
                    if (empty($user->avatar) && !empty($data['photo'])) {
                        $update_data['avatar'] = $data['photo'];
                    }
                    $user = service('Api\User')->update($user, $update_data);
                    
                    $user->token = $user->createToken($user->email)->plainTextToken;
                    return $user;
                }
            }
        }

        if (auth()->check()) {
            return auth()->user();
        }

        return null;
    }

    public function login(Game $game, Player $player, $data)
    {

        $user = service('Api\User')->getByEmail($data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->message('game.login.wrong_password', 'error', 422);
        }

        $player = service('Api\Player')->update($player, ['user_id' => $user->id]);

        $user->token = $user->createToken($user->email)->plainTextToken;

        return $user;
    }

    public function logout(Game $game, Player $player)
    {
        $user = auth()->user();
        $fake_user = $this->pre_register(['locale' => $user->locale->code]);        

        $player = service('Api\Player')->update($player, ['user_id' => $fake_user->id]);

        return $fake_user;
    }

    public function recovery($email, $link)
    {
        $user = service('Api\User')->getByEmail($email);

        if ( ! empty($user)) {
            $hash = service('Api\User')->addRandomHash($user, Uhash::TYPE_RECOVERY, now()->addDay());
            service('Api\Mail')->sendRecoveryEmail($user->email, str_replace('{hash}', $hash, $link));

            return true;
        }

        return response()->message('game.recovery.wrong_email', 'error', 422);
    }

    public function password(Uhash $hash, $password)
    {
        $user = $hash->users()->first();

        if (empty($user) || $hash->type != Uhash::TYPE_RECOVERY) {
            return response()->message('game.recovery.wrong_hash', 'error', 422);
        }

        $data = [
            'password' => bcrypt($password),
        ];

        $user = service('Api\User')->update($user, $data);
        $user = service('Api\User')->removeRandomHash($user, Uhash::TYPE_RECOVERY);

        $user->token = $user->createToken($user->email)->plainTextToken;

        return $user;
    }

    public function hash(Uhash $hash)
    {
        return $hash->users()->first();
    }

    public function activate(Uhash $hash)
    {
        $user = $hash->users()->first();

        if (empty($user) || $hash->type != Uhash::TYPE_ACTIVATE) {
            return response()->message('game.activate.wrong_hash', 'error', 422);
        }

        $user = service('Api\User')->update($user, [
            'email_verified_at' => now(),
        ]);

        $user = service('Api\User')->removeRandomHash($user, Uhash::TYPE_ACTIVATE);

        return $user;
    }
}
