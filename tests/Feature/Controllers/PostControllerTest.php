<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    /*private GlossaryService $glossaryService;

    private User $user1;
    private Glossary $glossary1;
    private Glossary $glossary2;
    private Glossary $glossary3;*/

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

        /*$this->glossaryService = $this->app->make('App\Services\GlossaryService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->glossary1 = Glossary::factory()->create(
            ['term' => [
                'en' => 'kinesphere',
                'it' => 'kinesfera',
            ]]
        )->setStatus('published');
        $this->glossary2 = Glossary::factory()->create()->setStatus('published');
        $this->glossary3 = Glossary::factory()->create()->setStatus('published');*/
    }


    /** @test */
    public function itShouldRedirectTheGuestUserAccessingThePostsPageToLoginPage()
    {
        $response = $this->get('posts');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayThePostsIndexPageToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();

        $response = $this->get('posts');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }

    /** @test */
    public function itShouldBlockTheAdminAccessingThePostsPageWithoutPostIndexPermissionToLoginPage()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('posts');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayThePostsIndexPageToAdminWithPostIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('posts.view');

        $response = $this->get('posts');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }




}