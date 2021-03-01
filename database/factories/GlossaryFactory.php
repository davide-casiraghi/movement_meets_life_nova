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
            'term' => [
                'en' => $this->faker->word,
                'it' => $this->faker->word,
            ],
            'definition' => [
                'en' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
                'it' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            ],
            'body' => [
                'en' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
                'it' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            ],
            'is_published' => $this->faker->boolean(50),
            'question_type' => 1,
        ];
    }
}
