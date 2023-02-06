<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\Login as AuthLoginRequest;
use App\Http\Resources\Admin\User\Me as UserMeResourse;

class AuthController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function me(Request $request)
    {
        $me = service('Admin\Auth')->me();
        return response()->result( $me ? new UserMeResourse($me) : $me);
    }

    public function login(AuthLoginRequest $request)
    {
        $input = $request->only(['email', 'password']);
        $result = service('Admin\Auth')->login($input);
        $message = 'Ви успішно увійшли';

        return response()->result(new UserMeResourse($result), $message);
    }

    public function logout()
    {
        $result = service('Admin\Auth')->logout();
        
        return response()->result(true);
    }
}
