<?php

namespace Module\Category\tests\Feature\Crud;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Module\Category\Models\Category;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function admin_can_store_category()
    {
        $this->CreateUser('admin');
        $category = Category::factory()->raw();

        $this->post(route('category.store', 'en'), $category)
            ->assertCreated();
    }


    /** @test */
    public function user_can_not_store_category()
    {
        $this->CreateUser();
        $category = Category::factory()->raw();

        $this->post(route('category.store'), $category)
            ->assertForbidden();
    }

    /** @test */
    public function super_can_store_category()
    {
        $this->CreateUser('super');
        $category = Category::factory()->raw();

        $this->post(route('category.store'), $category)
            ->assertCreated();
    }
}
