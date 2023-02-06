<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\User;

class UserRepository
{
    public function all()
    {
        return User::where('is_admin', false)->get();
    }

    public function get($id)
    {
        return User::find($id);
    }

    public function getByAppId($app_id)
    {
        return User::where('app_id', $app_id)->first();
    }

    public function getByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->fill($data);
        $user->save();
        return $user;
    }

    public function addRandomHash(User $user, string $type, $expired_at = null)
    {
        $hash = $user->hashes()->firstOrNew([
            'type' => $type,
        ]);

        if ($hash->exists) {
            $user->hashes()->detach($hash->id);
        }

        $hash->hash = md5(Str::random(10));
        $hash->expired_at = $expired_at;
        $user->hashes()->save($hash);

        return $hash->hash;
    }

    public function removeRandomHash(User $user, string $type)
    {
        $hash = $user->hashes()->firstOrNew([
            'type' => $type,
        ]);

        if ($hash->exists) {
            $user->hashes()->detach($hash->id);
            $hash->delete();
        }

        return $user;
    }
}
