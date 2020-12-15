<?php

namespace Database\Factories;

use App\Models\Organizer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organizer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'website' => $this->faker->url,
            'user_id' => '1',
            'email' => $this->faker->unique()->safeEmail,
            'description' => $this->faker->paragraph,
            'phone' => $this->faker->e164PhoneNumber,

            'country_id' => $this->faker->numberBetween($min = 1, $max = 250),
        ];
    }
}
