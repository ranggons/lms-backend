<?php

namespace Tests\Feature\Rangon\Auth;

use App\Models\User;
use Tests\Feature\Rangon\RangonTestCase;
use App\Notifications\Auth\ResetPassword;
use App\Notifications\Auth\PasswordChanged;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use App\Traits\Testing\AuthenticationTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordTest extends RangonTestCase
{
    use RefreshDatabase, AuthenticationTestTrait;

    public $endpoint = "api/founding-father/auth/forgot-password";
    public $resetPasswordEndpoint = "api/founding-father/auth/reset-password";

    public function test_should_send_reset_password_link_via_email()
    {
        Notification::fake();
        $user = User::create(
            [
                'name'      =>  'Testing User',
                'email'     =>  'testing.user@rangon.id',
                'password'  =>  bcrypt('password'),
            ]
        );
        $forgotPasswordInput = [
            'email' =>  $user->email
        ];
        $forgotPasswordResponse = $this->postRequest($this->endpoint, $forgotPasswordInput);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user, $forgotPasswordResponse) {
            $mailBlueprint = $notification->toMail($user);

            $this->assertStringContainsString($forgotPasswordResponse['token'], $mailBlueprint->render());

            return true;
        });

        $token = $forgotPasswordResponse['token'];
    }

    public function test_should_be_able_to_change_the_password()
    {
        Notification::fake();

        $user = User::create(
            [
                'name'      =>  'Testing User',
                'email'     =>  'testing.user@rangon.id',
                'password'  =>  bcrypt('password'),
            ]
        );
        $forgotPasswordInput = [
            'email' =>  $user->email
        ];
        $forgotPasswordResponse = $this->postRequest($this->endpoint, $forgotPasswordInput);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user, $forgotPasswordResponse) {
            $mailBlueprint = $notification->toMail($user);

            $this->assertStringContainsString($forgotPasswordResponse['token'], $mailBlueprint->render());

            return true;
        });

        $token = $forgotPasswordResponse['token'];

        $resetPasswordInput = [
            'password'                  =>  'password123',
            'password_confirmation'     =>  'password123',
            'token'                     =>  $token
        ];

        $resetPasswordResponse = $this->postRequest($this->resetPasswordEndpoint, $resetPasswordInput);

        Notification::assertSentTo($user, PasswordChanged::class, function ($notification) use ($user, $resetPasswordResponse) {
            $mailBlueprint = $notification->toMail($user);

            $this->assertStringContainsString(__('Your password has been changed.'), $mailBlueprint->render());

            return true;
        });

        $this->assertTrue($user->wasChanged());
    }
}
