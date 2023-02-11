<?php

namespace Tests\Feature\Rangon;

use Database\Seeders\TestingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\ApiTestCase;

class RangonTestCase extends ApiTestCase
{
    protected $seeder = TestingSeeder::class;
}
