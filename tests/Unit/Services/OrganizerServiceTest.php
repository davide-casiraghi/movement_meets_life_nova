<?php

namespace Tests\Unit\Services;

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
    public function it_should_create_an_organizer()
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
    public function it_should_update_an_organizer()
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
    public function it_should_return_organizer_by_id()
    {
        $organizer = $this->organizerService->getById($this->organizers[1]->id);

        $this->assertEquals($this->organizers[1]->id, $organizer->id);
    }

    /** @test */
    public function it_should_return_all_organizers()
    {
        $organizers = $this->organizerService->getOrganizers(20);
        $this->assertCount(3, $organizers);
    }

    /** @test */
    /*public function it_should_search_members_by_email()
    {
        $searchParameters = ['email' => 'info@aaa.com'];
        $users = $this->memberService->getMembers(20, $searchParameters);
        $this->assertCount(1, $users);
    }*/


    /** @test */
    /*public function it_should_search_members_by_region()
    {
        $searchParameters = ['regionId' => 5];
        $users = $this->memberService->getMembers(20, $searchParameters);
        $this->assertCount(1, $users);
    }*/

    /** @test */
    /*public function it_should_return_number_of_pending_members()
    {
        $numberPendingMembers = $this->memberService->countAllPendingMembers();

        $this->assertEquals(2, $numberPendingMembers);
    }*/


}