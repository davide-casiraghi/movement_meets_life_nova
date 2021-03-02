<?php

namespace App\Http\Controllers;

use App\Models\Glossary;
use App\Services\GlossaryService;
use App\Services\InsightService;
use App\Services\QuoteService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private GlossaryService $glossaryService;
    private InsightService $insightService;
    private QuoteService $quoteService;

    /**
     * DashboardController constructor.
     *
     * @param \App\Services\GlossaryService $glossaryService
     * @param \App\Services\InsightService $insightService
     * @param \App\Services\QuoteService $quoteService
     */
    public function __construct(
        GlossaryService $glossaryService,
        InsightService $insightService,
        QuoteService $quoteService
    ) {
        $this->glossaryService = $glossaryService;
        $this->insightService = $insightService;
        $this->quoteService = $quoteService;
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

        return view('dashboard.index', [
            'unpublishedGlossaryTerms' => $unpublishedGlossaryTerms,
            'latestInsights' => $latestInsights,
            'quote' => $quote,
        ]);
    }
}
