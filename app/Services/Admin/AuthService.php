<?php

namespace App\Services\Admin;

use App\Services\Service;

class AuthService extends Service
{
    public function __construct()
    {
        // 
    }

    public function me()
    {
        return auth()->user();
    }

    public function login(array $input)
    {
        if (auth()->attempt($input)) {
            $me = auth()->user();
            
            if ($me->is_admin) {
                $me->token = $me->createToken($me->email)->plainTextToken;
                return $me;
            }
        }

        return response()->message('auth.messages.login.wrong', 'error', 422);
    }

    public function logout()
    {
        auth()->logout();
    }
}
