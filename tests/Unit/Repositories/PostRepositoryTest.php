<?php

namespace Tests\Unit\Repositories;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class EventRepetitionRepositoryTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

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

        $this->postRepository = $this->app->make('App\Repositories\PostRepository');

        $this->user1 = User::factory()->create([
               'email' => 'admin@gmail.com',
           ]);

        $this->post1 = Post::factory()->create()->setStatus('published');
        $this->post2 = Post::factory()->create()->setStatus('published');
        $this->post3 = Post::factory()->create()->setStatus('published');
    }

}
