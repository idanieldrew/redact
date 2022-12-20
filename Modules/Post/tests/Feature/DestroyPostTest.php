<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\CustomTestCase;

class DestroyPostTest extends CustomTestCase
{
    use WithFaker, DatabaseMigrations;

    /** @test */
    public function destroy_post()
    {
        $this->withoutExceptionHandling();
        $res = $this->storePost('super');

        $this->delete(route('post.destroy', Str::slug($res[0][0])))
            ->assertOk();

        $this->assertSoftDeleted('posts', ['title' => $res[0][0]]);
    }

    /** @test */
    public function user_can_not_destroy_post()
    {
        $res = $this->storePost();
        $this->CreateUser('writer', 'test2@test.com');

        $this->delete(route('post.destroy', Str::slug($res[0][0])))
            ->assertForbidden();
    }
}
