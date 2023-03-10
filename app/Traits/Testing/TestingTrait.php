<?php

namespace App\Traits\Testing;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait TestingTrait
{
    public bool $debugData = true;

    public function showDebugMessage(string $message, $data = null, bool $isFinish = false)
    {
        print_r(`\n\n===================================\n` . PHP_EOL);
        print_r($message . PHP_EOL);
        if ($data) {
            print_r(`\n\n===================================\n` . PHP_EOL);
            print_r($data);
            print_r(PHP_EOL);
        }
        if ($isFinish) {
            print_r(`\n\n===================================\n` . PHP_EOL);
        }
    }

    public function checkInvalidMessage(array $response, string $message, string $code = null, string $status = null)
    {
        $this->assertEquals($response['message'], $message, 'Expected message equals to ' . $message);
        if ($code) {
            $this->assertEquals($response['code'], $code, 'Expected code equals to ' . $code);
        }
        if ($status) {
            $this->assertEquals($response['status'], $status, 'Expected status equals to ' . $status);
        }
    }

    public function setActor($actor = null, string $return = null)
    {
        if (!$actor) {
            $actor = User::query()->inRandomOrder()->first();
        }

        if ($return == 'token') {
            return $actor->createToken('testing')->plainTextToken;
        }
        return Sanctum::actingAs(
            $actor,
            ['*']
        );
    }

    public function initStub($class)
    {
        if (is_string($class)) {
            $class = app($class)::class;
        }

        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
    }
}
