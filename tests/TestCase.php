<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // set your headers here
        $this->withHeader('X-localization', 'en');
    }
}
