<?php

namespace Tests\Unit\Services;

use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Models\Organizer;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Venue;
use App\Models\EventCategory;
use App\Services\EventService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class EventFactoryTest extends TestCase{

    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private User $user1;
    private Collection $teachers;
    private Collection $organizers;
    private Collection $venues;

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

        $this->user1 = User::factory()->create([
            'name' => 'Paolo',
            'email' => 'admin@gmail.com',
        ]);

        $this->teachers = Teacher::factory()->count(3)->create();
        $this->organizers = Organizer::factory()->count(3)->create();
        $this->venues = Venue::factory()->count(3)->create();
    }

    /** @test */
    public function it_should_create_an_event()
    {
        $event = Event::factory()->create(['title' => 'test title']);

        $this->assertDatabaseHas('events', ['title' => 'test title']);
    }

    /** @test */
    public function it_should_create_an_event_with_no_repeat()
    {
        $event = Event::factory()->create(['title' => 'test title']);

        $this->assertDatabaseHas('events', [
            'title' => 'test title',
            'repeat_type' => 1,
        ]);
    }

    /** @test */
    public function it_should_create_an_event_with_weekly_repetition()
    {
        $event = Event::factory()->create([
            'title' => 'test second title',
            'repeat_type' => 2,
            ]);

        $this->assertDatabaseHas('events', [
            'title' => 'test second title',
            'repeat_type' => 2,
            'repeat_weekly_on' => '{"1":"on","3":"on"}',
            'repeat_until' => '2025-12-01 00:00:00',
        ]);
    }

    /** @test */
    public function it_should_create_an_event_with_monthly_repetition()
    {
        $event = Event::factory()->create([
            'title' => 'test monthly title',
            'repeat_type' => 3,
            ]);

        $this->assertDatabaseHas('events', [
            'title' => 'test monthly title',
            'repeat_type' => 3,
            'on_monthly_kind' => '1|4|1',
            'repeat_until' => '2025-12-01 00:00:00',
        ]);
    }

    /** @test */
    public function it_should_create_an_event_with_multiple_dates_repetition()
    {
        $event = Event::factory()->create([
            'title' => 'event multiple dates title',
            'repeat_type' => 4,
        ]);

        // The factory create a repetition for the day of the event + three dates
        // specified in the multiple date field
        $this->assertCount(4, $event->repetitions);

        $this->assertDatabaseHas('events', [
            'title' => 'event multiple dates title',
        ]);
    }












}