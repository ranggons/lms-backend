<?php

namespace App\Repositories\Rangon;

use App\Models\User;
use App\Notifications\Auth\PasswordChanged;
use App\Notifications\Auth\ResetPassword;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if (request()->user()->currentAccessToken()->delete()) {
            return true;
        }
        return false;
    }

    public function forgotPassword(array $validated)
    {
        $passwordReset = [
            'email'         =>  $validated['email'],
        ];

        $user = User::where('email', $validated['email'])->first();

        do {
            $passwordReset['token'] = str()->random(60);
        } while (
            DB::table('password_resets')->where('token', $passwordReset['token'])->exists()
        );

        DB::table('password_resets')->insert(
            [
                'email'         =>  $passwordReset['email'],
                'token'         =>  $passwordReset['token'],
                'created_at'    =>  Carbon::now(),
                'valid_until'   =>  Carbon::now()->addSeconds(config('auth.passwords.users.expire', 300)),
            ],
        );


        $user->notify(new ResetPassword($passwordReset));
        return $passwordReset;
    }

    public function resetPassword(array $validated)
    {
        $query = DB::table('password_resets')->where('token', $validated['token'])->where('valid_until', '>', now());
        if ($query->exists()) {
            $passwordReset = $query->first();
            $query->delete();
            $user = User::where('email', $passwordReset->email)->first();
            $user->update(
                [
                    'password'  =>  bcrypt($validated['password']),
                ],
            );
            if ($user->wasChanged()) {
                $user->notify(new PasswordChanged());
                return [
                    'status'    =>  true,
                    'message'   =>  'Password has been changed!'
                ];
            }
            return [
                'status'    =>  false,
                'message'   =>  `Password couldn't be changed. Please try again later`,
            ];
        }
        return [
            'status'  =>  false,
            'message'   =>  'Token is invalid',
        ];
    }
}
