<?php

namespace Tests\Feature\Services;

use App\Models\Glossary;
use App\Services\GlossaryVariantService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GlossaryVariantServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private GlossaryVariantService $glossaryVariantService;

    private $glossary1;

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

        $this->glossaryVariantService = $this->app->make('App\Services\GlossaryVariantService');

        $this->glossary1 = Glossary::factory()->create(
            [
                'term' => [
                    'en' => 'kinesphere',
                    'it' => 'kinesfera',
                ],
                'is_published' => true
            ]
        );

    }

    /** @test */
    public function itShouldCreateAGlossaryVariant()
    {
        $glossaryVariant = $this->glossaryVariantService->createGlossaryVariant($this->glossary1);

        $this->assertDatabaseHas('glossary_variants', ['id' => $glossaryVariant->id]);
    }
}
