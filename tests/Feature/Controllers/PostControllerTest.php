<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private Post $post1;
    private Post $post2;
    private Post $post3;

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

        $this->user1 = User::factory()->create(['email' => 'admin@gmail.com']);
        $userProfile = UserProfile::factory()->create(['user_id' => $this->user1->id]);

        $this->postCategory1 = PostCategory::factory()->create();

        $this->post1 = Post::factory()->create(['category_id' => 1, 'user_id' => 1])->setStatus('published');
        $this->post2 = Post::factory()->create(['category_id' => 1, 'user_id' => 1])->setStatus('published');
        $this->post3 = Post::factory()->create(['category_id' => 1, 'user_id' => 1])->setStatus('published');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingThePostsPageToLoginPage()
    {
        $response = $this->get('posts');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayThePostsIndexViewToSuperAdmin()
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
    public function itShouldDisplayThePostsIndexViewToAdminWithPostIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('posts.view');

        $response = $this->get('posts');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }

    /** @test */
    public function itShouldDisplayThePostsShowViewToGuestUser()
    {
        $response = $this->get("/posts/{$this->post1->id}");

        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
    }






}