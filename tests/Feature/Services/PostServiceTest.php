<?php

namespace Tests\Feature\Services;

use App\Http\Requests\PostSearchRequest;
use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
        $this->post2 = Post::factory()->create(['category_id' => 1])->setStatus('published');
        $this->post3 = Post::factory()->create(['category_id' => 1])->setStatus('published');
    }

    /** @test */
    public function itShouldCreateAPost()
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
    public function itShouldUpdateAPost()
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

    /** @test */
    public function itShouldReturnAPostById()
    {
        $post = $this->postService->getById($this->post1->id);

        $this->assertEquals($this->post1->id, $post->id);
    }

    /** @test */
    public function itShouldDeleteAPost()
    {
        $this->postService->deletePost($this->post1->id);
        $this->assertDatabaseMissing('posts', ['id' => $this->post1->id]);
    }

    /** @test */
    public function itShouldGetPostBody()
    {
        $this->post1->body = 'test body';
        $this->post1->save();

        $body = $this->postService->getPostBody($this->post1);

        $this->assertEquals($body, 'test body');
    }

    /** @test */
    public function itShouldGetNumberPostsCreatedLastThirtyDays(){
        $numberPostsCreatedLastThirtyDays = $this->postService->getNumberPostsCreatedLastThirtyDays();
        $this->assertEquals($numberPostsCreatedLastThirtyDays, 3);
    }

    /** @test */
    public function itShouldGetSearchParameters(){

        $request = new PostSearchRequest();
        $data = [
            'title' => 'test title',
            'categoryId' => 1,
            'startDate' => '2020-06-05',
            'endDate' => '2020-06-12',
            'status' => 'published',
        ];
        $request->merge($data);


        $searchParameters = $this->postService->getSearchParameters($request);
        $this->assertEquals($searchParameters['title'], 'test title');
    }






}