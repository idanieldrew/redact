<?php

namespace Module\Category\tests\Feature\Crud;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Module\Category\Models\Category;
use Tests\TestCase;

class ReadTest extends TestCase
{
    use DatabaseMigrations,WithFaker;

    /** @test */
    public function see_all_categories()
    {
        $user = $this->CreateUser();

        $category = Category::factory()->count(5)->raw();
        $user->categories()->createMany($category);

        $this->get(route('category.index'))
            ->assertOk();
    }

    /** @test */
    public function see_single_category()
    {
        $user = $this->CreateUser();

        $category = $user->categories()->create([
            'name' => $this->faker->title
        ]);

        $this->get(route('category.show',$category->slug))
            ->assertSee([$category->name , $category->slug])
            ->assertOk();
    }
}