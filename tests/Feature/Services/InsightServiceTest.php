<?php

namespace Tests\Feature\Services;

use App\Http\Requests\InsightStoreRequest;
use App\Models\Insight;
use App\Models\User;
use App\Services\InsightService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InsightServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private InsightService $insightService;

    private User $user1;
    private Insight $insight1;
    private Insight $insight2;
    private Insight $insight3;

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

        $this->insightService = $this->app->make('App\Services\InsightService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->insight1 = Insight::factory()->create();
        $this->insight2 = Insight::factory()->create();
        $this->insight3 = Insight::factory()->create();
    }

    /** @test */
    public function itShouldCreateAInsight()
    {
        $request = new insightStoreRequest();
        $data = [
            'title' => 'test title',
            'body' => 'test body',
        ];
        $request->merge($data);

        $insight = $this->insightService->createinsight($request);

        $this->assertDatabaseHas('insights', ['id' => $insight->id]);
    }

    /** @test */
    public function itShouldUpdateAInsight()
    {
        $request = new insightStoreRequest();

        $data = [
            'title' => 'test title updated',
            'body' => 'test body updated',
        ];
        $request->merge($data);

        $this->insightService->updateinsight($request, $this->insight1);

        $this->assertDatabaseHas('insights', ['body' => 'test body updated']);
    }

    /** @test */
    public function itShouldReturnAInsightById()
    {
        $insight = $this->insightService->getInsightById($this->insight1->id);

        $this->assertEquals($this->insight1->id, $insight->id);
    }

    /** @test */
    public function itShouldReturnAllInsights()
    {
        $insights = $this->insightService->getInsights(20);
        $this->assertCount(3, $insights);
    }

    /** @test */
    public function itShouldDeleteAInsight()
    {
        $this->insightService->deleteinsight($this->insight1->id);
        $this->assertDatabaseMissing('insights', ['id' => $this->insight1->id]);
    }
}
