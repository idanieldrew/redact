<?php

namespace Module\Image\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\Image\Models\Image;

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
            'image' =>  $faker->imageUrl
        ];
    }
}