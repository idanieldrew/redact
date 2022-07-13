<?php

namespace Module\Post\Database\Factories;

use Module\Category\Models\Category;
use Module\Post\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        $category_number = 2;
        $categories = Category::factory()->count($category_number)->create(['user_id' => auth()->user()]);

        return [
            'title' => $faker->jobTitle,
            'details' => $faker->paragraph(1),
            'description' => $faker->paragraph(6),
            'banner' => $faker->imageUrl,
//            'tag_request' => array('tag1'),
//            'category' => $categories->pluck('name')->toArray(),
        ];
    }
}
