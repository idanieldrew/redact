<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\CustomTestCase;

class UpdatePostTest extends CustomTestCase
{
    use DatabaseMigrations, WithFaker;

    private function updateLicense(string $role): \Illuminate\Testing\TestResponse
    {
        $res = $this->storePost($role);
        return $this->patch(route('post.license-update', Str::slug($res[0][0])), [
            'name' => 'accepted',
            'reason' => 'no problem'
        ]);
    }

    /** @test */
    public function updating_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', Str::slug($res[0][0])), ['title' => 'test']);

        $this->assertDatabaseHas('posts', ['title' => 'test']);
    }

    /** @test */
    public function when_title_update_slug_should_update()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', Str::slug($res[0][0])), ['title' => 'test']);

        $this->assertDatabaseHas('posts', ['slug' => 'test']);
    }

    /** @test */
    public function handle_length_title_update_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', Str::slug($res[0][0])), ['title' => 'te'])
            ->assertJsonValidationErrors("title");
    }

    /** @test */
    public function handle_length_details_update_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', Str::slug($res[0][0])), ['details' => 'test'])
            ->assertJsonValidationErrors("details");
    }

    /** @test */
    public function handle_length_description_update_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', Str::slug($res[0][0])), ['description' => 'test test'])
            ->assertJsonValidationErrors("description");
    }

    /** @test */
    public function admin_can_update_license_post()
    {
        $this->updateLicense('admin')->assertOk();
        $this->assertDatabaseHas('statuses',[
           'name' => 'accepted'
        ]);
    }

    /** @test */
    public function super_can_update_license_post()
    {
        $this->updateLicense('super')->assertOk();
        $this->assertDatabaseHas('statuses',[
            'name' => 'accepted'
        ]);
    }

    /** @test */
    public function writer_cant_update_license_post()
    {
        $this->updateLicense('writer')->assertForbidden();
        $this->assertDatabaseMissing('statuses',[
            'name' => 'accepted'
        ]);
    }
}
