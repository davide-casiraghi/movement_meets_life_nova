<?php

namespace Tests\Feature\Services;

use App\Http\Requests\TagStoreRequest;
use App\Models\Tag;
use App\Models\User;
use App\Services\TagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private tagService $tagService;

    private User $user1;
    private Tag $tag1;
    private Tag $tag2;
    private Tag $tag3;

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

        $this->tagService = $this->app->make('App\Services\TagService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->tag1 = Tag::factory()->create();
        $this->tag2 = Tag::factory()->create();
        $this->tag3 = Tag::factory()->create();
    }

    /** @test */
    public function itShouldCreateATag()
    {
        $request = new tagStoreRequest();
        $data = [
            'tag' => 'test tag',
        ];
        $request->merge($data);

        $tag = $this->tagService->createtag($request);

        $this->assertDatabaseHas('tags', ['id' => $tag->id]);
    }

    /** @test */
    public function itShouldUpdateATag()
    {
        $request = new tagStoreRequest();

        $data = [
            'tag' => 'test tag updated',
        ];
        $request->merge($data);

        $this->tagService->updatetag($request, $this->tag1->id);

        $this->assertDatabaseHas('tags', ['tag' => "{\"en\":\"test tag updated\",\"sl\":null}"]);
    }

    /** @test */
    public function itShouldReturnATagById()
    {
        $tag = $this->tagService->getById($this->tag1->id);

        $this->assertEquals($this->tag1->id, $tag->id);
    }

    /** @test */
    public function itShouldReturnAllTags()
    {
        $tags = $this->tagService->getTags(20);
        $this->assertCount(3, $tags);
    }

    /** @test */
    public function itShouldDeleteATag()
    {
        $this->tagService->deletetag($this->tag1->id);
        $this->assertDatabaseMissing('tags', ['id' => $this->tag1->id]);
    }
}