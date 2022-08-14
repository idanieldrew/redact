<?php

namespace Module\Category\tests\Feature\Crud;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Module\Category\Models\Category;
use Tests\TestCase;

class ReadTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test */
    public function see_all_categories()
    {
        $this->CreateUser();
        Category::factory()->create(['user_id' => auth()->user()]);

        $this->get(route('category.index'))
            ->assertOk();
    }

    /** @test */
    public function see_single_category()
    {
        $this->CreateUser();

        $category = auth()->user()->categories()->create([
            'name' => [
                'en' => $this->faker->jobTitle,
                'fa' => 'تست'
            ]
        ]);

        $this->get(route('category.show',$category->slug))
            ->assertSee([$category->getTranslation('name', 'en'), $category->slug])
            ->assertOk();
    }
}
