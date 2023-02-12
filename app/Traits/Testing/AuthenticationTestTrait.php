<?php

namespace App\Traits\Testing;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait AuthenticationTestTrait
{
    public $defaultType = 'model';

    public $dummyUser = [
        [
            'name'      =>  'Testing User',
            'email'     =>  'testing.user@rangon.id',
            'password'  =>  'password',
        ]
    ];

    public function createuser(array $data = null)
    {
        if ($this->defaultType == 'model') {
            $user = $this->createUserByModel($data);
        }
    }

    public function createUserByModel(array $data = null)
    {
        if ($data) {
            return User::create($data);
        }
        return User::create($this->dummyUser);
    }

    public function prepareInput(array $inputs = null)
    {
        if (!$inputs) {
            $inputs = $this->dummyUser;
        }
        if (isset($inputs['password'])) {
            $inputs['password'] = bcrypt($inputs['password']);
        }
        return $inputs;
    }

    public function login($endpoint, $credentials)
    {
        return $this->postRequest($endpoint, $credentials);
    }
}
