<?php

namespace Module\Category\tests\Feature\Crud;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Module\Category\Models\Category;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /** @test */
    public function store_category()
    {
        $this->CreateUser('admin');
        $category = Category::factory()->raw();

        $this->post(route('category.store'),$category)
            ->assertCreated();
    }

    /** @test */
    public function handle_length_name_in_store_category()
    {
        $this->CreateUser('admin');
        $category = Category::factory()->raw(['name' => 'te']);

        $this->post(route('category.store'),$category)
            ->assertStatus(422);
    }

    /** @test */
    public function handle_unique_name_in_store_category()
    {
        $user = $this->CreateUser('admin');
        $categoryOne = Category::factory()->create(['name' => 'test','user_id' => $user->id]);

        $categoryTwo = Category::factory()->raw(['user_id' => $user->id,'name' => 'test']);

        $this->post(route('category.store'),$categoryTwo)
            ->assertStatus(422);
    }

    /** @test */
    public function user_can_not_store_category()
    {
        $this->CreateUser('user');
        $category = Category::factory()->raw();

        $this->post(route('category.store'),$category)
            ->assertForbidden();
    }

    /** @test */
    public function super_can_store_category()
    {
        $this->CreateUser('super');
        $category = Category::factory()->raw();

        $this->post(route('category.store'),$category)
            ->assertCreated();
    }
}
