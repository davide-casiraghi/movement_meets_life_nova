<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Http\Livewire\AddTeacher;

class AddTeacherTest extends TestCase
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
    }

    /** @test */
    public function canSeeAddTeacherModal()
    {
        $teachers = [];
        $selected = [];

        Livewire::test(AddTeacher::class, [$teachers, $selected])
            ->assertDontSee('Create new teacher')
            ->set('showModal', true)
            ->assertSee('Create new teacher');
    }
    

}