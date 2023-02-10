<?php

namespace App\Traits\Testing;

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
}
