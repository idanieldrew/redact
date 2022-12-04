<?php

namespace Module\Plan\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CustomTestCase;

class StoreTest extends CustomTestCase
{
    use RefreshDatabase;

    /** @test */
    public function store_new_premium()
    {
        $this->CreateUser();
        $this->post(route('premium.store'));

        $this->assertDatabaseHas('premium', ['name' => 'test']);
    }
}
