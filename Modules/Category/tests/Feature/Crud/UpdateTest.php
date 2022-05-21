<?php

namespace Module\Category\tests\Feature\Crud;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use DatabaseMigrations,WithFaker;

    private $name = "test";
    private function storeCategory($type = 'admin')
    {
        $user = $this->CreateUser($type);
        $category = $user->categories()->create([
            'name' => $this->faker->name
        ]);

        return $category;
    }

    /** @test */
    public function update_category()
    {
        $category = $this->storeCategory();

        $this->patch(route('category.update',$category->slug),[
            'name' => $this->name
        ]);

        $this->assertDatabaseHas('categories',
            ['name' => $this->name]
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
        $category = $this->storeCategory();

        $this->patch(route('category.update',$category->slug),[
            'name' => $this->name
        ]);

        $this->assertDatabaseHas('categories',
            ['slug' => Str::slug($this->name)]
        );
    }

    /** @test */
    public function user_can_not_update_category()
    {
        $category = $this->storeCategory('user');

        $this->patch(route('category.update',$category->slug),[
            'name' => $this->name
        ])->assertForbidden();
    }

    /** @test */
    public function super_can_update_category()
    {
        $category = $this->storeCategory('super');

        $this->patch(route('category.update',$category->slug),[
            'name' => $this->name
        ]);

        $this->assertDatabaseHas('categories',
            ['name' => $this->name]
        );
    }
}