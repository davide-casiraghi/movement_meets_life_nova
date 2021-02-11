<?php

namespace Tests\Feature\Services;

use App\Http\Requests\OrganizerStoreRequest;
use App\Models\Organizer;
use App\Models\User;
use App\Services\OrganizerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class OrganizerServiceTest extends TestCase{

    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private OrganizerService $organizerService;

    private User $user1;
    private Collection $organizers;

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

        $this->organizerService = $this->app->make('App\Services\OrganizerService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->organizers = Organizer::factory()->count(3)->create();
    }

    /** @test */
    public function itShouldCreateAnOrganizer()
    {
        $user = $this->authenticateAsUser();

        $request = new OrganizerStoreRequest();

        $data = [
            'name' => 'test new name',
            'surname' => 'test surname',
            'email' => 'test@newemail.com',
            'description' => 'test@newemail.com',
            'website' => 'test@newemail.com',
            'facebook' => 'test@newemail.com',
            'phone' => 'test@newemail.com',
        ];
        $request->merge($data);

        $this->organizerService->createOrganizer($request);

        $this->assertDatabaseHas('organizers', ['name' => 'test new name']);
    }

    /** @test */
    public function itShouldUpdateAnOrganizer()
    {
        $request = new OrganizerStoreRequest();

        $data = [
            'name' => 'name updated',
            'surname' => 'test surname',
            'email' => 'test@newemail.com',
            'description' => 'test@newemail.com',
            'website' => 'test@newemail.com',
            'facebook' => 'test@newemail.com',
            'phone' => 'test@newemail.com',
        ];
        $request->merge($data);

        $this->organizerService->updateOrganizer($request, $this->organizers[1]->id);

        $this->assertDatabaseHas('organizers', ['name' => 'name updated']);
    }

    /** @test */
    public function itShouldReturnAnOrganizerById()
    {
        $organizer = $this->organizerService->getById($this->organizers[1]->id);

        $this->assertEquals($this->organizers[1]->id, $organizer->id);
    }

    /** @test */
    public function itShouldReturnAllOrganizers()
    {
        $organizers = $this->organizerService->getOrganizers(20);
        $this->assertCount(3, $organizers);
    }

    /** @test */
    public function itShouldDeleteAnOrganizer()
    {
        $this->organizerService->deleteOrganizer($this->organizers[1]->id);
        $this->assertDatabaseMissing('organizers', ['id' => $this->organizers[1]->id]);
    }

    /** @test */
    public function itShouldReturnNumberOrganizersCreatedLastThirtyDays()
    {
        $number = $this->organizerService->getNumberOrganizersCreatedLastThirtyDays();

        $this->assertSame(3, $number);
    }

}