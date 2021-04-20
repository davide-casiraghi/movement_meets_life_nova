<?php

namespace App\Http\Controllers;

use App\Models\Glossary;
use App\Services\GlossaryService;
use App\Services\InsightService;
use App\Services\PostService;
use App\Services\QuoteService;
use App\Services\TestimonialService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private GlossaryService $glossaryService;
    private InsightService $insightService;
    private QuoteService $quoteService;
    private PostService $postService;
    private TestimonialService $testimonialService;

    /**
     * DashboardController constructor.
     *
     * @param  \App\Services\GlossaryService  $glossaryService
     * @param  \App\Services\InsightService  $insightService
     * @param  \App\Services\QuoteService  $quoteService
     * @param  \App\Services\PostService  $postService
     * @param  \App\Services\TestimonialService  $testimonialService
     */
    public function __construct(
        GlossaryService $glossaryService,
        InsightService $insightService,
        QuoteService $quoteService,
        PostService $postService,
        TestimonialService $testimonialService
    ) {
        $this->glossaryService = $glossaryService;
        $this->insightService = $insightService;
        $this->quoteService = $quoteService;
        $this->postService = $postService;
        $this->testimonialService = $testimonialService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $searchParameters = [];
        $searchParameters['is_published'] = 0;

        $unpublishedGlossaryTerms = $this->glossaryService->getGlossaries(100, $searchParameters)->all();
        $latestInsights = $this->insightService->getLatestInsights(5);
        $quote = $this->quoteService->getQuoteOfTheDay('backend');

        $totalPublishedInsightsNumber = $this->insightService->getPublishedInsightsNumber();
        $totalPublishedPostsNumber = $this->postService->getPublishedPostsNumber();
        $totalPublishedTestimonialsNumber = $this->testimonialService->getPublishedTestimonialsNumber();

        return view('dashboard.index', [
            'unpublishedGlossaryTerms' => $unpublishedGlossaryTerms,
            'latestInsights' => $latestInsights,
            'quote' => $quote,
            'totalInsights' => $totalPublishedInsightsNumber,
            'totalPosts' => $totalPublishedPostsNumber,
            'totalTestimonials' => $totalPublishedTestimonialsNumber,
        ]);
    }
}
