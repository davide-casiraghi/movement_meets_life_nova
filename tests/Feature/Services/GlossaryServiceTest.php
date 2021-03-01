<?php

namespace Tests\Feature\Services;

use App\Http\Requests\GlossaryStoreRequest;
use App\Models\Glossary;
use App\Models\GlossaryVariant;
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

    private GlossaryVariant $glossaryVariant1;
    private GlossaryVariant $glossaryVariant2;
    private GlossaryVariant $glossaryVariant3;

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

        $this->glossary1 = Glossary::factory()->create(
            ['term' => [
                'en' => 'kinesphere',
                'it' => 'kinesfera',
            ]]
        );
        $this->glossary2 = Glossary::factory()->create();
        $this->glossary3 = Glossary::factory()->create();

        $this->glossaryVariant1 = GlossaryVariant::factory()->create([
            'glossary_id' => $this->glossary1->id,
            'term' => [
                'en' => 'kinesphere',
                'it' => 'kinesfera',
            ]
        ]);

        $this->glossaryVariant2 = GlossaryVariant::factory()->create([
             'glossary_id' => $this->glossary1->id,
             'term' => [
                 'en' => 'kinespheres',
                 'it' => 'kinesfere',
             ]
         ]);

    }

    /** @test */
    public function itShouldCreateAGlossary()
    {
        $request = new GlossaryStoreRequest();

        $data = [
            'term' => 'test term name',
            'definition' => 'test term definition',
            'body' => 'test term body',
            'question_type' => 1,
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
            'question_type' => 1,
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

        $termPresent = $this->glossaryService->variantIsPresent($text, $term);
        $this->assertSame(true, $termPresent);
    }

    /** @test */
    public function itShouldReturnThatTheTermIsNotPresent()
    {
        $text = "In velit sapien, viverra at felis molestie, placerat egestas nunc.";
        $term = "lorem";

        $termPresent = $this->glossaryService->variantIsPresent($text, $term);
        $this->assertSame(false, $termPresent);
    }

    /** @test */
    public function itShouldMarkGlossaryTerms()
    {
        $text = "In velit kinesphere, viverra at felis molestie, placerat egestas nunc.";

        $textWithHoverableTerm = $this->glossaryService->markGlossaryTerms($text);

        $this->assertStringContainsString("<a href='/glossaryTerms/", $textWithHoverableTerm);
    }

    /** @test */
    public function itShouldReplaceGlossaryVariant()
    {
        $text = "In velit kinesphere, viverra at felis molestie, placerat egestas nunc.";
        $count = 1;

        $currentLanguageVariantTerm = 'kinesphere';
        $glossaryTermId = $this->glossary1->id;

        $textWithTermReplaced = $this->glossaryService->replaceGlossaryVariant($currentLanguageVariantTerm, $glossaryTermId, $text, $count);
        $this->assertStringContainsString("<a href='/glossaryTerms/", $textWithTermReplaced);
    }

    /** @test */
    public function itShouldAttachTermDescription()
    {
        $text = "In velit kinesphere, viverra at felis molestie, placerat egestas nunc.";

        $textWithTermDescription = $this->glossaryService->attachTermDescription($this->glossary1, $text);
        $this->assertStringContainsString("kinesphere", $textWithTermDescription);
        $this->assertStringContainsString($this->glossary1->definition, $textWithTermDescription);
    }





}