<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventRepetition;
use App\Repositories\EventRepetitionRepository;
use App\Services\GlobalServices;
use Carbon\Carbon;
use Faker\Provider\DateTime;
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

    protected ?string $startDate = null;
    protected ?string $endDate = null;
    protected ?string $timeStart = null;
    protected ?string $timeEnd = null;
    protected ?string $repeatUntil = null;

   // private ?string $val = null;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


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

            'repeat_type' => 1, // If not specified the event created is one time event

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
        $this->startDate = Carbon::today()->addDays(rand(0, 365))->isoFormat('D/M/Y');
        $this->endDate = Carbon::createFromFormat('d/m/Y', $this->startDate)
                                 ->addDays(2)->isoFormat('D/M/Y');
            //$this->faker->dateTimeThisYear($max = 'now', $timezone = null)->format('d-m-Y');;
        //$this->endDate = $this->faker->dateTimeBetween($this->startDate, $this->startDate->format('Y-m-d H:i:s').' +2 days')->format('d-m-Y');;
        $this->timeStart = '20:00:00';
        $this->timeEnd = '22:00:00';
        $this->repeatUntil = "1/1/2025";

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
                    $event->on_monthly_kind = '1|4|1';
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
                    // Convert the start date in a format that can be used for strtotime
                    $dateStart = implode('-', array_reverse(explode('/', $this->startDate)));

                    // Calculate repeat until day
                    $repeatUntilDate = implode('-', array_reverse(explode('/', $this->repeatUntil)));

                    EventRepetitionRepository::saveWeeklyRepeatDates($event->id, array_keys(json_decode($event->repeat_weekly_on, true)), $dateStart, $repeatUntilDate, $this->timeStart, $this->timeEnd);
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
