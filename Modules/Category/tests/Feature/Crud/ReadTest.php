<?php

namespace Module\Category\tests\Feature\Crud;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Module\Category\Models\Category;
use Tests\TestCase;

class ReadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function see_all_categories()
    {
        Category::factory(10)->create();

        $this->get(route('category.index'))
            ->assertOk();
    }

    /** @test */
    public function see_single_category()
    {
        $category = Category::factory()->create();

        $this->get(route('category.show',$category->slug))
            ->assertSee([$category->name , $category->slug])
            ->assertOk();
    }
}