<?php

namespace Tests\Feature\Services;

use App\Http\Requests\GlossaryStoreRequest;
use App\Models\Glossary;
use App\Models\User;
use App\Services\GlossaryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class GlossaryServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private GlossaryService $glossaryService;

    private User $user1;
    private Glossary $glossary1;
    private Glossary $glossary2;
    private Glossary $glossary3;

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

        $this->glossaryService = $this->app->make('App\Services\GlossaryService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->glossary1 = Glossary::factory()->create()->setStatus('published');
        $this->glossary2 = Glossary::factory()->create()->setStatus('published');
        $this->glossary3 = Glossary::factory()->create()->setStatus('published');
    }

    /** @test */
    public function itShouldCreateAGlossary()
    {
        $request = new GlossaryStoreRequest();

        $data = [
            'term' => 'test term name',
            'definition' => 'test term definition',
            'body' => 'test term body',
        ];
        $request->merge($data);

        $glossaryTerm = $this->glossaryService->createGlossary($request);

        $this->assertDatabaseHas('glossaries', ['id' => $glossaryTerm->id]);
    }

    /** @test */
    public function itShouldUpdateAGlossary()
    {
        $request = new GlossaryStoreRequest();

        $data = [
            'term' => 'term updated',
            'definition' => 'test term definition updated',
            'body' => 'test term body updated',
        ];
        $request->merge($data);

        $this->glossaryService->updateGlossary($request, $this->glossary1->id);

        $this->assertDatabaseHas('glossaries', ['term' => "{\"en\":\"term updated\",\"sl\":null}"]);
    }

    /** @test */
    public function itShouldReturnGlossaryById()
    {
        $glossary = $this->glossaryService->getById($this->glossary1->id);

        $this->assertEquals($this->glossary1->id, $glossary->id);
    }

    /** @test */
    public function itShouldReturnAllGlossariess()
    {
        $glossarys = $this->glossaryService->getGlossaries(20);
        $this->assertCount(3, $glossarys);
    }

    /** @test */
    public function itShouldDeleteAGlossary()
    {
        $this->glossaryService->deleteGlossary($this->glossary1->id);
        $this->assertDatabaseMissing('glossaries', ['id' => $this->glossary1->id]);
    }

    /** @test */
    public function itShouldReturnThatTheTermIsPresent()
    {
        $text = "In velit sapien, viverra at felis molestie, placerat egestas nunc.";
        $term = "sapien";

        $termPresent = $this->glossaryService->termIsPresent($text, $term);
        $this->assertSame(true, $termPresent);
    }



}