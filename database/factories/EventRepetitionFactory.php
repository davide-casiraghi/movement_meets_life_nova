<?php

namespace Database\Factories;

use App\Models\EventRepetition;
use App\Services\GlobalServices;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EventRepetitionFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventRepetition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {

        $date_start_timestamp = rand(1895589603, 1924447203);
        $date_start = Carbon::parse($date_start_timestamp);
        $date_end = $date_start->addDay();

        return [
            'event_id' => rand(10, 100),
            'start_repeat' => $date_start,
            'end_repeat' => $date_end,
        ];
    }

}
