<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Write to log file
        file_put_contents(storage_path('logs/laravel.log'), "");
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    // I need the posts to see the HP
    /*public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/
}
