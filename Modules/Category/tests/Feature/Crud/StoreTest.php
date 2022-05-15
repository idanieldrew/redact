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
        $user = $this->CreateUser();
        $category = Category::factory()->raw(['user_id' => $user->id]);

        $this->post(route('category.store'),$category)
            ->assertCreated();
    }

    /** @test */
    public function handle_length_name_in_store_category()
    {
        $user = $this->CreateUser();
        $category = Category::factory()->raw(['user_id' => $user->id,'name' => 'te']);

        $this->post(route('category.store'),$category)
            ->assertStatus(422);
    }

    /** @test */
    public function handle_unique_name_in_store_category()
    {
        $user = $this->CreateUser();
        $categoryOne = Category::factory()->create(['user_id' => $user->id,'name' => 'test']);

        $categoryTwo = Category::factory()->raw(['user_id' => $user->id,'name' => 'test']);

        $this->post(route('category.store'),$categoryTwo)
            ->assertStatus(422);
    }
}