<?php

namespace Tests\Unit\Commands;

use App\Console\Commands\GenerateSitemap;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateSitemapTest extends TestCase
{
    use InteractsWithConsole;
    use RefreshDatabase; // empty the test DB

    private Post $post1;

    public function setUp(): void
    {
        parent::setUp();

        // Write to log file
        file_put_contents(storage_path('logs/laravel.log'), "");

        // Seeders - /database/seeds
        $this->seed();

        User::factory()->create(['email' => 'admin@gmail.com']);
        PostCategory::factory()->create();
        $this->post1 = Post::factory()->create(['category_id' => 1, 'slug' => 'test'])->setStatus('published');
    }

    /** @test */
    public function itShouldGenerateTheSitemap()
    {
        $this->artisan(GenerateSitemap::class)
            ->assertExitCode(0);
    }
}
