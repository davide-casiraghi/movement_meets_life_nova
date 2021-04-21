<?php

namespace Tests\Feature\Services;

use App\Http\Requests\TestimonialStoreRequest;
use App\Models\Testimonial;
use App\Models\User;
use App\Services\TestimonialService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestimonialServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private TestimonialService $testimonialService;

    private User $user1;
    private Testimonial $testimonial1;
    private Testimonial $testimonial2;
    private Testimonial $testimonial3;

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

        $this->testimonialService = $this->app->make('App\Services\TestimonialService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->testimonial1 = Testimonial::factory()->create()->setStatus('published');
        $this->testimonial2 = Testimonial::factory()->create()->setStatus('published');
        $this->testimonial3 = Testimonial::factory()->create()->setStatus('published');
    }

    /** @test */
    public function itShouldCreateATestimonial()
    {
        $request = new testimonialStoreRequest();
        $data = [
            'name' => 'test name',
            'surname' => 'test surname',
            'email' => 'test@test.com',
            'profession' => 'test profession',
            'feedback' => 'test feedback',
            'country_id' => 1,
        ];
        $request->merge($data);

        $testimonial = $this->testimonialService->createtestimonial($request);

        $this->assertDatabaseHas('testimonials', ['id' => $testimonial->id]);
    }

    /** @test */
    public function itShouldUpdateATestimonial()
    {
        $request = new testimonialStoreRequest();

        $data = [
            'name' => 'test name updated',
            'surname' => 'test surname updated',
            'email' => 'test@test.com',
            'profession' => 'test profession updated',
            'feedback' => 'test feedback updated',
            'feedback_short' => 'test feedback short',
            'country_id' => 1,
        ];
        $request->merge($data);

        $this->testimonialService->updatetestimonial($request, $this->testimonial1->id);

        $this->assertDatabaseHas('testimonials', ['feedback' => "{\"en\":\"test feedback updated\",\"sl\":null}"]);
    }

    /** @test */
    public function itShouldReturnATestimonialById()
    {
        $testimonial = $this->testimonialService->getById($this->testimonial1->id);

        $this->assertEquals($this->testimonial1->id, $testimonial->id);
    }

    /** @test */
    public function itShouldReturnAllTestimonials()
    {
        $testimonials = $this->testimonialService->getTestimonials(20);
        $this->assertCount(3, $testimonials);
    }

    /** @test */
    public function itShouldDeleteATestimonial()
    {
        $this->testimonialService->deletetestimonial($this->testimonial1->id);
        $this->assertDatabaseMissing('testimonials', ['id' => $this->testimonial1->id]);
    }
}
