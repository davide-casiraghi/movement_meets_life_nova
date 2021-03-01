<?php

namespace Database\Factories;

use App\Models\GlossaryVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class GlossaryVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GlossaryVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'glossary_id' => 1,
            'term' => [
                'en' => $this->faker->word,
                'it' => $this->faker->word,
            ],
        ];
    }
}
