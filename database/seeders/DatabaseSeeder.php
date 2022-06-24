<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Module\Category\Database\Seeders\CategorySeeder;
use Module\Category\Models\Category;
use Module\Image\Models\Image;
use Module\Post\Models\Post;
use Module\Tag\Models\Tag;
use Module\User\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $super = User::factory()->create(['type' => 'super']);

        User::factory(4)->create()->each(function ($user) {
            $user->categories()->save(Category::factory()->make());
            $user->posts()->save(Post::factory()->make())->each(function ($post) {
                $post->tags()->save(Tag::factory()->make());
//                $post->images()->save(Media::factory()->make());
            });
        });
    }
}