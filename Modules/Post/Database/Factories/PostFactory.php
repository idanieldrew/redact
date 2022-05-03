<?php

namespace Module\Post\Database\Factories;

use Illuminate\Support\Str;
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

        return [
            'title' => $faker->jobTitle,
            'details' =>  $faker->paragraph(1),
            'description' => $faker->paragraph(6),
            'banner' => $faker->imageUrl
        ];
    }
}