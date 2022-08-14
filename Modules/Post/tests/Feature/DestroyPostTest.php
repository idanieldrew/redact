<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class DestroyPostTest extends TestCase
{
    use WithFaker,DatabaseMigrations;

    /** @test */
    public function destroy_post()
    {
        $res = $this->storePost('super');

        $this->delete(route('post.destroy', Str::slug($res[0])))
            ->assertOk();

        $this->assertSoftDeleted('posts', ['title' => $res[0]]);
    }

    /** @test */
    public function user_can_not_destroy_post()
    {
        $res = $this->storePost();
        $this->CreateUser();

        $this->delete(route('post.destroy', Str::slug($res[0])))
            ->assertForbidden();
    }
}
