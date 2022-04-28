<?php

namespace Module\Post\Database\Factories;

use Illuminate\Support\Str;
use Module\Post\Models\Image;
use Module\Post\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'name' => $faker->word,
            'address' =>  $faker->imageUrl
        ];
    }
}