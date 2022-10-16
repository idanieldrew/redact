<?php

namespace Module\Category\tests\Feature\Crud;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Module\Category\Models\Category;
use Tests\CustomTestCase;

class UpdateTest extends CustomTestCase
{
    use DatabaseMigrations, WithFaker;

    private string $name = "test";

    private function storeCategory($type = 'admin')
    {
        $res = $this->CreateUser($type);
        return Category::factory()->create(['user_id' => $res[0]->id]);
    }

    /** @test */
    public function update_categories()
    {
        $category = $this->storeCategory();

        $this->patch(route('category.update', $category->slug), [
            'name' => [
                'en' => "test",
                'fa' => "تست"
            ]
        ])->assertNoContent();

        $this->assertDatabaseHas('categories',
            ['slug' => 'test']
        );
    }

    /** @test */
    public function user_can_not_update_category()
    {
        $category = $this->storeCategory('writer');

        $this->patch(route('category.update', $category->slug), [
            'name' => [
                'en' => "test",
                'fa' => "تست"
            ]])->assertForbidden();
    }

    /** @test */
    public function super_can_update_category()
    {
        $category = $this->storeCategory('super');

        $this->patch(route('category.update', $category->slug), [
            'name' => [
                'en' => "test",
                'fa' => "تست"
            ]
        ])->assertNoContent();

        $this->assertDatabaseHas('categories',
            ['slug' => 'test']
        );
    }
}
