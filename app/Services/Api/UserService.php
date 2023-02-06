<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\UserRepository;
use App\User;
use App\Game;
use App\Player;
use App\Hash;

class UserService extends Service
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $input)
    {
        return $this->userRepository->create($input);
    }

    public function update(User $user, $data)
    {
        return $this->userRepository->update($user, $data);
    }

    public function settings($data)
    {
        $user = auth()->user();
        $update[$data['field']] = $data['value'];
        return $this->userRepository->update($user, $update);
    }

    public function register(Game $game, Player $player, array $input)
    {
        if (!empty($input['app_id'])) {
            $user = $this->getByAppId($input['app_id']);
            if (!$user && !empty($input['email'])) {
                $user = $this->getByEmail($input['email']);
            }

            if ($user) {
                $player = service('Api\Player')->update($player, ['user_id' => $user->id]);

                $user->token = $user->createToken($user->email)->plainTextToken;
                return $user;
            }
        }

        if (!empty($input['email'])) {
            if ($this->userRepository->getByEmail($input['email'])) {
                return response()->message('game.register.email_exist', 'error', 422);
            }
        }

        $user = auth()->user();
        if (!empty($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        if (!empty($input['app_id']) || !empty($input['password'])) {
            $input['is_registered'] = true;
        }

        $hash = $this->addRandomHash($user, Hash::TYPE_ACTIVATE);
        service('Api\Mail')->sendVerifyEmail($user->email, str_replace('{hash}', $hash, $input['link']));

        if (empty($user->avatar) && !empty($input['photo'])) {
            $base64_image = base64_encode(file_get_contents($input['photo']));
            $path = service('Api\Upload')->upload_image($base64_image);
            $input['avatar'] = $path;
        }

        $player = service('Api\Player')->update($player, ['user_id' => $user->id]);

        return $this->userRepository->update($user, $input);
    }

    public function getByAppId($app_id)
    {
        return $this->userRepository->getByAppId($app_id);
    }

    public function getByEmail($email)
    {
        return $this->userRepository->getByEmail($email);
    }

    public function addRandomHash(User $user, string $type, $expired_at = null)
    {
        return $this->userRepository->addRandomHash($user, $type, $expired_at);
    }

    public function removeRandomHash(User $user, string $type)
    {
        return $this->userRepository->removeRandomHash($user, $type);
    }
}
