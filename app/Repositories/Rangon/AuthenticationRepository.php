<?php

namespace App\Repositories\Rangon;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class AuthenticationRepository extends BaseRepository
{
    protected $model = User::class;

    public function login(array $request)
    {
        if (!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return null;
        }

        $user = app($this->model)->where('email', $request['email'])->first();

        $token = $user->createToken('SUDO')->plainTextToken;

        $user = $user->toArray();

        $user['token'] = $token;

        return $user;
    }

    public function logout()
    {
        if (auth()->user()->currentAccessToken()->delete()) {
            return true;
        }
        return false;
    }
}
