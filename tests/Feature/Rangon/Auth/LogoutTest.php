<?php

namespace Tests\Feature\Rangon\Auth;

use Tests\TestCase;
use App\Models\User;
use Tests\Feature\Rangon\RangonTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class LogoutTest extends RangonTestCase
{
    use RefreshDatabase;

    protected $endpoint = "api/founding-father/auth/logout";
    protected $loginendpoint = "api/founding-father/auth/login";

    protected $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->debugData = false;
    }

    public function test_logout_with_default_actor()
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
        $response = $this->postRequest($this->loginendpoint, $credentials);
        $token = $response['token'];
        $this->postRequest(
            $this->endpoint,
            [],
            null,
            ['*'],
            [
                'Authorization' =>  'Bearer ' . $token
            ]
        );
    }
}
