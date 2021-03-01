<?php

namespace Database\Factories;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author' => $this->faker->name($gender = 'male' | 'female'),
            'description' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            'is_published' => $this->faker->boolean(50),
            'is_public' => $this->faker->boolean(50),
        ];
    }
}
