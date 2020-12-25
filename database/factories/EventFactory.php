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
    private Carbon $randomDate2;
    private Carbon $randomDate3;

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
        // Before storing the event we set the event parameters for repetitions
        return $this->afterMaking(function (Event $event) {

            switch ($event->repeat_type) {
                case 1: // No repeat - one time event
                    break;
                case 2: // Weekly
                    $event->repeat_weekly_on = '{"1":"on","3":"on"}';
                    $event->repeat_until = new Carbon('first day of December 2025');
                    break;
                case 3: // Monthly
                    $event->repeat_monthly_on = '';
                    $event->on_monthly_kind = '';
                    $event->repeat_until = new Carbon('first day of December 2025');
                    break;
                case 4: // Multiple dates
                    $this->randomDate1 = Carbon::today()->subDays(rand(0, 365));
                    $this->randomDate2 = Carbon::today()->subDays(rand(0, 365));
                    $this->randomDate3 = Carbon::today()->subDays(rand(0, 365));

                    $randomDate1String = $this->randomDate1->isoFormat('D/M/Y');
                    $randomDate2String = $this->randomDate2->isoFormat('D/M/Y');
                    $randomDate3String = $this->randomDate3->isoFormat('D/M/Y');

                    $event->multiple_dates = $randomDate1String.','.$randomDate2String.','.$randomDate3String;
                    break;
            }

        // After storing the event we create the repetitions
        })->afterCreating(function (Event $event) {
            switch ($event->repeat_type) {
                case 1: // No repeat - one time event
                    EventRepetition::factory()->create([
                        'event_id' => $event->id,
                    ]);
                    break;
                case 2: // Weekly

                    break;
                case 3: // Monthly

                    break;
                case 4: // Multiple dates
                    EventRepetition::factory()->create([
                        'event_id' => $event->id,
                    ]);
                    EventRepetition::factory()->create([
                        'event_id' => $event->id,
                        'start_repeat' => $this->randomDate1->hour(20)->minute(00),
                        'end_repeat' => $this->randomDate1->hour(22)->minute(00),
                    ]);
                    EventRepetition::factory()->create([
                        'event_id' => $event->id,
                        'start_repeat' => $this->randomDate2->hour(20)->minute(00),
                        'end_repeat' => $this->randomDate2->hour(22)->minute(00),
                    ]);
                    EventRepetition::factory()->create([
                        'event_id' => $event->id,
                        'start_repeat' => $this->randomDate3->hour(20)->minute(00),
                        'end_repeat' => $this->randomDate3->hour(22)->minute(00),
                    ]);
                    break;
            }
        });
    }
}
