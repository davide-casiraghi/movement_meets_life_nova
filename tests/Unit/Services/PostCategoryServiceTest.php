<?php

namespace Tests\Unit\Services;

use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\PostCategoryStoreRequest;
use App\Http\Requests\PostSearchRequest;
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
use App\Services\PostCategoryService;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class PostCategoryServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private PostCategoryService $postCategoryService;

    private User $user1;
    private PostCategory $postCategory1;
    private PostCategory $postCategory2;
    private PostCategory $postCategory3;

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

        $this->postCategoryService = $this->app->make('App\Services\PostCategoryService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->postCategory1 = PostCategory::factory()->create();
        $this->postCategory2 = PostCategory::factory()->create();
        $this->postCategory3 = PostCategory::factory()->create();
    }

    /** @test */
    public function itShouldCreateAPostCategory()
    {
        $request = new PostCategoryStoreRequest();
        $data = [
            'name' => 'test name',
            'description' => 'test description',
        ];
        $request->merge($data);

        $postCategory = $this->postCategoryService->createPostCategory($request);

        $this->assertDatabaseHas('post_categories', ['id' => $postCategory->id]);
    }

    /** @test */
    public function itShouldUpdateAPostCategory()
    {
        $request = new PostCategoryStoreRequest();

        $data = [
            'name' => 'test name updated',
            'description' => 'test description updated',
        ];
        $request->merge($data);

        $this->postCategoryService->updatePostCategory($request, $this->postCategory1->id);

        $this->assertDatabaseHas('post_categories', ['name' => 'test name updated']);
    }

    /** @test */
    public function itShouldReturnAPostCategoryById()
    {
        $postCategory = $this->postCategoryService->getById($this->postCategory1->id);

        $this->assertEquals($this->postCategory1->id, $postCategory->id);
    }

    /** @test */
    public function itShouldDeleteAPostCategory()
    {
        $this->postCategoryService->deletePostCategory(1);
        $this->assertDatabaseMissing('post_categories', ['id' => $this->postCategory1->id]);
    }
}