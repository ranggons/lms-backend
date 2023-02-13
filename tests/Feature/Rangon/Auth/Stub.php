<?php

namespace Tests\Feature\Rangon\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Stub extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function login()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
