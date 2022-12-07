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

    /** @test */
    public function writer_cant_store_new_plan()
    {
        $this->CreateUser('admin');
        $this->post(route('plan.store'), $this->plan)->assertForbidden();

        $this->assertDatabaseMissing('plans', ['name' => 'pro']);
    }

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
    public function required_name_in_store_plan()
    {
        $plan = [
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

        $this->CreateUser('super');
        $this->post(route('plan.store'), $plan)->assertUnprocessable();

        $this->assertDatabaseMissing('plans', ['name' => 'pro']);
    }

    /** @test */
    public function unique_name_in_store_plan()
    {
        $plan = [
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

        $this->CreateUser('super');
        $this->post(route('plan.store'), $this->plan)->assertCreated();

        $this->post(route('plan.store'), $plan)->assertUnprocessable();
    }

    /** @test */
    public function required_countAccount_in_store_plan()
    {
        $plan = [
            'name' => 'pro',
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

        $this->CreateUser('super');
        $this->post(route('plan.store'), $plan)->assertUnprocessable();
    }

    /** @test */
    public function minimum_countAccount_in_store_plan()
    {
        $plan = [
            'name' => 'pro',
            'count_account' => 0,
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

        $this->CreateUser('super');
        $this->post(route('plan.store'), $plan)->assertUnprocessable();
    }

    /** @test */
    public function description_should_array_in_store_plan()
    {
        $plan = [
            'name' => 'pro',
            'count_account' => 1,
            'description' => 'test 1',
            'price' => 10.99,
            'period' => 15,
            'interval' => 'day',
            'features' => [
                'test feature 1',
                'test feature 2'
            ]
        ];

        $this->CreateUser('super');
        $this->post(route('plan.store'), $plan)->assertUnprocessable();
    }

    /** @test */
    public function price_should_numeric_in_store_plan()
    {
        $plan = [
            'name' => 'pro',
            'count_account' => 1,
            'description' => ['test 1'],
            'price' => "test price",
            'period' => 15,
            'interval' => 'day',
            'features' => [
                'test feature 1',
                'test feature 2'
            ]
        ];

        $this->CreateUser('super');
        $this->post(route('plan.store'), $plan)->assertUnprocessable();
    }
}
