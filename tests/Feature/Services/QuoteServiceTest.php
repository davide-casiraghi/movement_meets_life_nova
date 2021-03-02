<?php

namespace Tests\Feature\Services;

use App\Http\Requests\QuoteStoreRequest;
use App\Models\Quote;
use App\Models\User;
use App\Services\QuoteService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class QuoteServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private QuoteService $quoteService;

    private User $user1;
    private Quote $quote1;
    private Quote $quote2;
    private Quote $quote3;

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

        $this->quoteService = $this->app->make('App\Services\QuoteService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->quote1 = Quote::factory()->create(['show_where' => 'frontend', 'is_published' => true]);
        $this->quote2 = Quote::factory()->create(['show_where' => 'backend', 'is_published' => true]);
        $this->quote3 = Quote::factory()->create(['show_where' => 'both', 'is_published' => true]);
    }

    /** @test */
    public function itShouldCreateAQuote()
    {
        $request = new quoteStoreRequest();
        $data = [
            'author' => 'test author',
            'description' => 'test description',
            'show_where' => 'frontend',
        ];
        $request->merge($data);

        $quote = $this->quoteService->createquote($request);

        $this->assertDatabaseHas('quotes', ['id' => $quote->id]);
    }

    /** @test */
    public function itShouldUpdateAQuote()
    {
        $request = new quoteStoreRequest();

        $data = [
            'author' => 'test author updated',
            'description' => 'test description updated',
            'show_where' => 'backend',
        ];
        $request->merge($data);

        $this->quoteService->updatequote($request, $this->quote1->id);

        $this->assertDatabaseHas('quotes', ['author' => "test author updated"]);
    }

    /** @test */
    public function itShouldReturnAQuoteById()
    {
        $quote = $this->quoteService->getById($this->quote1->id);

        $this->assertEquals($this->quote1->id, $quote->id);
    }

    /** @test */
    public function itShouldReturnAllQuotes()
    {
        $quotes = $this->quoteService->getQuotes(20);
        $this->assertCount(3, $quotes);
    }

    /** @test */
    public function itShouldDeleteAQuote()
    {
        $this->quoteService->deletequote($this->quote1->id);
        $this->assertDatabaseMissing('quotes', ['id' => $this->quote1->id]);
    }

    /** @test */
    public function itShouldReturnTheQuoteOfTheDay()
    {
        $quote = $this->quoteService->getQuoteOfTheDay('backend');

        $this->assertInstanceOf(Quote::class, $quote);
        $this->assertSame(2, $quote->id);
    }

    /** @test */
    public function itShouldResetQuotesShownAttributeAndReturnTheQuoteOfTheDay()
    {
        // Set all the frontend quotes as shown
        $yesterday = Carbon::yesterday();
        Quote::whereIn('show_where', ['frontend', 'both'])
            ->update(['shown_frontend_on' => $yesterday]);

        $quote = $this->quoteService->getQuoteOfTheDay('frontend');

        $this->assertInstanceOf(Quote::class, $quote);
        $this->assertSame(1, $quote->id);
    }
}