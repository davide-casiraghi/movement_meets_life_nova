<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Testimonial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName($gender = 'male' | 'female'),
            'surname' => $this->faker->lastName,
            'profession' => [
                'en' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
                'it' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            ],
            'feedback' => [
                'en' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
                'it' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            ],
            'country_id' => $this->faker->numberBetween($min = 1, $max = 250),
            'photo' => 'placeholders/placeholder-150x150.png',
            'personal_data_agreement' => 1,
            'publish_agreement' => 1,

            //'status' => $this->faker->randomElement(['pending', 'approved']),


        ];
    }
}
