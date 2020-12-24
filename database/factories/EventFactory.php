<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventRepetition;
use App\Services\GlobalServices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    private Carbon $randomDate1;

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
            'description' => [
                'en' => $this->faker->text($maxNbChars = 200),
                'it' => $this->faker->text($maxNbChars = 200),
            ],
            'contact_email' => $this->faker->email,
            'website_event_link' => $this->faker->url,
            'facebook_event_link' => $this->faker->url,
            //'image' => 'placeholders/placeholder-768x768.png',


            'venue_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'event_category_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'user_id' => 1,

            'repeat_type' => 1,
            //'user_id' => $this->faker->numberBetween($min = 1, $max = 3),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Event $event) {

            switch ($event->repeat_type) {
                case 1:

                    break;
                case 2:
                    $event->repeat_weekly_on = '{"1":"on","3":"on"}';
                    $event->repeat_until = new Carbon('first day of December 2025');
                    break;
                case 3:
                    $event->repeat_monthly_on = '';
                    $event->on_monthly_kind = '';
                    $event->repeat_until = new Carbon('first day of December 2025');
                    break;
                case 4:
                    $this->randomDate1 = Carbon::today()->subDays(rand(0, 365));
                    $this->randomDate2 = Carbon::today()->subDays(rand(0, 365));
                    $this->randomDate3 = Carbon::today()->subDays(rand(0, 365));

                    $randomDate1String = $this->randomDate1->isoFormat('D/M/Y');
                    $randomDate2String = $this->randomDate1->isoFormat('D/M/Y');
                    $randomDate3String = $this->randomDate1->isoFormat('D/M/Y');

                    $event->multiple_dates = $randomDate1String.','.$randomDate2String.','.$randomDate3String;
                    break;
            }

        })->afterCreating(function (Event $event) {
            switch ($event->repeat_type) {
                case 1:
                    EventRepetition::factory()->create([
                        'event_id' => $event->id,
                    ]);
                    break;
                case 2:

                    break;
            }
        });
    }
}
