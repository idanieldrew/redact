<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class DestroyPostTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test */
    public function destroy_post()
    {
        $this->withoutExceptionHandling();
        $res = $this->storePost('super');

        $this->delete(route('post.destroy', ['lang' => 'en', 'post' => Str::slug($res[0])]))
            ->assertOk();

        $this->assertSoftDeleted('posts', ['title' => $res[0]]);
    }
}
