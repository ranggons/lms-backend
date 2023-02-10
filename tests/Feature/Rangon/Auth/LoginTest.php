<?php

namespace Tests\Feature\Rangon\Auth;

use Tests\TestCase;
use App\Models\User;
use Tests\Feature\Rangon\RangonTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends RangonTestCase
{
    use RefreshDatabase;

    protected $endpoint = "api/founding-father/auth/login";

    public function test_login_with_dummy_super_user()
    {
        $credentials = [
            'email'     =>  'rangon@rangon.id',
            'password'  =>  'password',
        ];
        $this->postRequest($this->endpoint, $credentials);
    }

    public function test_login_with_newly_created_super_user()
    {
        $credentials = [
            'name'      =>  'Testing User',
            'email'     =>  'testing.user@rangon.id',
            'password'  =>  'password',
        ];
        User::create($credentials);
        $this->validateCall = false;
        $response = $this->postRequest($this->endpoint, $credentials);
        $this->checkInvalidMessage($response, __('The credentials provided does not match with our record.'));
    }
}
