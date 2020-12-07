<?php

namespace Database\Factories;

use App\Models\Inspiration;
use Illuminate\Database\Eloquent\Factories\Factory;

class InspirationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inspiration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author' => $this->faker->name($gender = 'male'|'female'),
            'description' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
        ];
    }
}
