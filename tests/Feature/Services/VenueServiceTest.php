<?php

namespace Tests\Feature\Services;

use App\Http\Requests\VenueStoreRequest;
use App\Models\Venue;
use App\Models\User;
use App\Services\VenueService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VenueServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private VenueService $venueService;

    private User $user1;
    private Venue $venue1;
    private Venue $venue2;
    private Venue $venue3;

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

        $this->venueService = $this->app->make('App\Services\VenueService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->venue1 = Venue::factory()->create();
        $this->venue2 = Venue::factory()->create();
        $this->venue3 = Venue::factory()->create();
    }

    /** @test */
    public function itShouldCreateAVenue()
    {
        $request = new venueStoreRequest();
        $data = [
            'name' => 'test name',
            'description' => 'test description',
            'website' => 'https://www.test.com',
            'address' => 'test address',
            'city' => 'test city',
            'country_id' => 1,
            'zip_code' => 'test zip',
        ];
        $request->merge($data);

        $venue = $this->venueService->createvenue($request);

        $this->assertDatabaseHas('venues', ['id' => $venue->id]);
    }

    /** @test */
    public function itShouldUpdateAVenue()
    {
        $request = new venueStoreRequest();

        $data = [
            'name' => 'test name updated',
            'description' => 'test description',
            'website' => 'https://www.test.com',
            'address' => 'test address',
            'city' => 'test city',
            'country_id' => 1,
            'zip_code' => 'test zip',
        ];
        $request->merge($data);

        $this->venueService->updatevenue($request, $this->venue1->id);

        $this->assertDatabaseHas('venues', ['name' => "test name updated"]);
    }

    /** @test */
    public function itShouldReturnAVenueById()
    {
        $venue = $this->venueService->getById($this->venue1->id);

        $this->assertEquals($this->venue1->id, $venue->id);
    }

    /** @test */
    public function itShouldReturnAllVenues()
    {
        $venues = $this->venueService->getVenues(20);
        $this->assertCount(3, $venues);
    }

    /** @test */
    public function itShouldDeleteAVenue()
    {
        $this->venueService->deletevenue($this->venue1->id);
        $this->assertDatabaseMissing('venues', ['id' => $this->venue1->id]);
    }

    /** @test */
    public function itShouldGetNumberVenuesCreatedLastThirtyDays()
    {
        $numberVenuesCreatedLastThirtyDays = $this->venueService->getNumberVenuesCreatedLastThirtyDays();
        $this->assertEquals($numberVenuesCreatedLastThirtyDays, 3);
    }
}