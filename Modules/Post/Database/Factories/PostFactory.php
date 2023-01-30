<?php

namespace Module\Post\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\Post\Models\Post;

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

        return [
            'title' => $faker->jobTitle,
            'details' => $faker->paragraph(1),
            'description' => $faker->paragraph(6),
            'banner' => $faker->imageUrl,
        ];
    }
}
