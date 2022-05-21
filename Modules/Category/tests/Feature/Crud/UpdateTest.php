<?php

namespace Module\Category\tests\Feature\Crud;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use DatabaseMigrations,WithFaker;

    private function storeCategory()
    {
        $user = $this->CreateUser('admin');
        $category = $user->categories()->create([
            'name' => $this->faker->name
        ]);

        return $category;
    }

    /** @test */
    public function update_category()
    {
        $name = 'test';
        $category = $this->storeCategory();

        $this->patch(route('category.update',$category->slug),[
            'name' => $name
        ]);

        $this->assertDatabaseHas('categories',
            ['name' => $name]
            );
    }

    /** @test */
    public function handle_length_name_in_update_category()
    {
        $name = 'te';
        $category = $this->storeCategory();

        $this->patch(route('category.update',$category->slug),[
            'name' => $name
        ]);

        $this->assertDatabaseMissing('categories',
            ['name' => $name]
        );
    }

    /** @test */
    public function check_update_slug_in_update_category()
    {
        $name = 'test';
        $category = $this->storeCategory();

        $this->patch(route('category.update',$category->slug),[
            'name' => $name
        ]);

        $this->assertDatabaseHas('categories',
            ['slug' => Str::slug($name)]
        );
    }
}