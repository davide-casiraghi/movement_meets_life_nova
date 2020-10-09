<?php

namespace Database\Factories;

use App\Models\Glossary;
use Illuminate\Database\Eloquent\Factories\Factory;

class GlossaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Glossary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'term' => $this->faker->word,
            'definition' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'body' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
        ];
    }
}
