<?php

namespace Module\Plan\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CustomTestCase;

class StoreTest extends CustomTestCase
{
    use RefreshDatabase, WithFaker;

    private array $plan = [
        'name' => 'pro',
        'count_account' => 1,
        'description' => [
            'test 1',
            'test 2'
        ],
        'price' => 10.99,
        'period' => 15,
        'interval' => 'day',
        'features' => [
            'test feature 1',
            'test feature 2'
        ]
    ];

    /*
        /** @test */
    public function admin_without_permission_cant_store_new_plan()
    {
        $this->CreateUser('admin');
        $this->post(route('plan.store'), $this->plan)->assertForbidden();

        $this->assertDatabaseMissing('plans', ['name' => 'pro']);
    }

    /** @test */
    public function admin_with_permission_can_store_new_plan()
    {
        $this->CreateUser('admin', 'test@test.com', true);
        $this->post(route('plan.store'), $this->plan)->assertCreated();

        $this->assertDatabaseHas('plans', ['name' => 'pro']);
    }

    /** @test */
    public function super_can_store_new_plan()
    {
        $this->CreateUser('super');
        $this->post(route('plan.store'), $this->plan)->assertCreated();

        $this->assertDatabaseHas('plans', ['name' => 'pro']);
    }

    /** @test */
    public function validation_error()
    {
        $this->CreateUser('super');
        $this->post(route('plan.store'), [])->assertUnprocessable();

        $this->assertDatabaseMissing('plans', ['name' => 'pro']);
    }

}
