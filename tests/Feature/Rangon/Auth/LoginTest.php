<?php

namespace Tests\Feature\Rangon\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Traits\Testing\AuthenticationTestTrait;
use Tests\Feature\Rangon\RangonTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends RangonTestCase
{
    use RefreshDatabase, AuthenticationTestTrait;

    protected $endpoint = "api/founding-father/auth/login";

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_login_with_dummy_super_user()
    {
        $credentials = [
            'email'     =>  'rangon@rangon.id',
            'password'  =>  'password',
        ];
        $this->login($this->endpoint, $credentials);
    }

    public function test_login_with_newly_created_super_user()
    {
        User::create(
            [
                'name'      =>  'Testing User',
                'email'     =>  'testing.user@rangon.id',
                'password'  =>  bcrypt('password'),
            ]
        );
        $credentials = [
            'email'     =>  'testing.user@rangon.id',
            'password'  =>  'password',
        ];
        $this->login($this->endpoint, $credentials);
    }

    public function test_login_with_unregistered_record()
    {
        $credentials = [
            'email'     =>  'testing.user@rangon.id',
            'password'  =>  'passwor',
        ];
        $this->validateCall = false;
        $response = $this->login($this->endpoint, $credentials);
        $this->checkInvalidMessage($response, __('The credentials provided does not match with our record.'));
    }
}
