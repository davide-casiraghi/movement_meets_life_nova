<?php

namespace Tests\Unit\Services;

use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\PostStoreRequest;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Models\Organizer;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Venue;
use App\Models\EventCategory;
use App\Services\EventService;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class PostServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private PostService $postService;

    private User $user1;
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

        $this->postService = $this->app->make('App\Services\PostService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->postCategory1 = PostCategory::factory()->create();
        $this->postCategory2 = PostCategory::factory()->create();
        $this->postCategory3 = PostCategory::factory()->create();
        $this->post1 = Post::factory()->create(['category_id' => 1])->setStatus('published');
        //$this->post2 = Post::factory()->create()->setStatus('published');
        //$this->post3 = Post::factory()->create()->setStatus('published');


    }

    /** @test */
    public function it_should_create_a_post()
    {
        $request = new PostStoreRequest();
        $data = [
            'title' => 'test title',
            'intro_text' => 'test intro text',
            'body' => 'test body',
            'category_id' => 1,
        ];
        $request->merge($data);

        $post = $this->postService->createPost($request);

        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }

    /** @test */
    public function it_should_update_a_post()
    {
        $request = new PostStoreRequest();

        $data = [
            'title' => 'title updated',
            'title_it' => 'test title it',
            'title_sl' => 'test title sl',
            'intro_text' => 'test intro text',
            'body' => 'test body',
            'category_id' => 1,
        ];
        $request->merge($data);

        $this->postService->updatePost($request, $this->post1->id);

        $this->assertDatabaseHas('posts', ['title' => "{\"en\":\"title updated\",\"it\":\"test title it\",\"sl\":\"test title sl\"}"]);
    }

}