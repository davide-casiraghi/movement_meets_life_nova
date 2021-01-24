<?php

namespace Tests\Unit\Repositories;

use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Models\Organizer;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Venue;
use App\Models\EventCategory;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class EventRepetitionRepositoryTest extends TestCase
{

    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private EventService $eventService;

    private User $user1;
    private Collection $teachers;
    private Collection $organizers;
    private Collection $venues;
    private Event $event1;
    private Event $event2;
    private Event $event3;

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Write to log file
        file_put_contents(storage_path('logs/laravel.log'), "");

        // Seeders - /database/seeds
        $this->seed();

        $this->eventRepetitionRepository = $this->app->make('App\Repositories\EventRepetitionRepository');

        $this->user1 = User::factory()->create([
                                                   'email' => 'admin@gmail.com',
                                               ]);

        $this->teachers = Teacher::factory()->count(3)->create();
        $this->organizers = Organizer::factory()->count(3)->create();
        $this->venues = Venue::factory()->count(3)->create();

        $this->event1 = Event::factory()->create()->setStatus('published');
        $this->event2 = Event::factory()->create()->setStatus('published');
        $this->event3 = Event::factory()->create()->setStatus('published');
    }



    /** @test */
    public function it_should_save_montly_repeat_dates()
    {
        $eventId = 3;
        $monthRepeatDatas = explode('|','1|1|5'); // First Friday of the month
        $startDate = '2020-06-15';
        $repeatUntilDate = '2020-08-15';
        $timeStart = '20:00:00';
        $timeEnd = '20:00:00';

        $onMonthlyKind = $this->eventRepetitionRepository->saveMonthlyRepeatDates($eventId, $monthRepeatDatas, $startDate, $repeatUntilDate, $timeStart, $timeEnd);

        $this->assertEquals("the 4th to last Thursday of the month", $onMonthlyKind);
    }
}