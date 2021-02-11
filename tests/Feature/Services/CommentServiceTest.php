<?php

namespace Tests\Feature\Services;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use App\Services\CommentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private CommentService $commentService;

    private User $user1;
    private Comment $comment1;
    private Comment $comment2;
    private Comment $comment3;
    private Post $post1;

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

        $this->commentService = $this->app->make('App\Services\CommentService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        /*$this->comment1 = Comment::factory()->create();
        $this->comment2 = Comment::factory()->create();
        $this->comment3 = Comment::factory()->create();*/

        $this->postCategory1 = PostCategory::factory()->create();
        $this->post1 = Post::factory()->create(['category_id' => 1])->setStatus('published');
    }

    /** @test */
    public function itShouldCreateAComment()
    {
        $request = new CommentStoreRequest();
        $data = [
            'email' => 'test@test.com',
            'name' => 'test comment name',
            'body' => 'test comment body',
        ];
        $request->merge($data);

        $comment = $this->commentService->createComment($request, $this->post1);

        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }


}