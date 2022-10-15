<?php

namespace Module\Category\tests\Feature\Crud;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Module\Category\Events\NewCategory;
use Module\Category\Models\Category;
use Tests\CustomTestCase;

class StoreTest extends CustomTestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function admin_can_store_category()
    {
        $this->CreateUser('admin');

        $category = Category::factory()->raw();

        $this->post(route('category.store'), $category)
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
    public function slug_should_english()
    {
        $this->CreateUser('admin');
        $category = [
            'name' => [
                'en' => 'test name',
                'fa' => 'تست فرضی'
            ]
        ];

        $this->post(route('category.store'), $category)
            ->assertCreated()
            ->assertJsonFragment(['slug' => 'test-name'])
            ->assertJsonMissing(['slug' => 'تست-فرضی']);
    }

    /** @test */
    public function super_can_store_category()
    {
        $this->CreateUser('super');
        $category = Category::factory()->raw();

        $this->post(route('category.store'), $category)
            ->assertCreated();
    }

    /** @test */
    public function work_event_for_store_category()
    {
        Event::fake([
            NewCategory::class
        ]);

        $this->CreateUser('admin');
        $category = Category::factory()->raw();

        $this->post(route('category.store'), $category);
        Event::assertDispatched(NewCategory::class);
    }
}
