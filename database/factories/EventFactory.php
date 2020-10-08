<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = $this->faker->dateTimeThisYear($max = 'now', $timezone = null);
        $end = $this->faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +2 days');

        return [
            'title' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'description' => $this->faker->text($maxNbChars = 200),
            'contact_email' => $this->faker->email,
            'website_event_link' => $this->faker->url,
            'facebook_event_link' => $this->faker->url,

            'status' => $this->faker->numberBetween($min = 0, $max = 1),
            'date_start' => $start,
            'date_end' => $end,

            'event_venue_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'event_category_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'user_id' => 1,
            //'user_id' => $this->faker->numberBetween($min = 1, $max = 3),
        ];
    }
}
