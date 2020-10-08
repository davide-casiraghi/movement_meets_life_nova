<?php

namespace Database\Factories;

use App\Models\Post;
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
        return [
            'title' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'body' => $this->faker->text($maxNbChars = 200),
            'status' => $this->faker->numberBetween($min = 0, $max = 1),
            'featured' => $this->faker->numberBetween($min = 0, $max = 1),
            'is_published' => $this->faker->numberBetween($min = 0, $max = 1),
            'category_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'created_by' => 1, //Auth user has a problem here
        ];
    }
}
