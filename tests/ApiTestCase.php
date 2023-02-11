<?php

namespace Tests;

use App\Traits\Testing\ApiCallTrait;
use App\Traits\Testing\TestingTrait;

abstract class ApiTestCase extends TestCase
{
    use ApiCallTrait, TestingTrait;

    protected $seed = true;
}
