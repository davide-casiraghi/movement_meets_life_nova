<?php

namespace App\Http\Controllers;

use App\Models\Glossary;
use App\Services\GlossaryService;
use App\Services\InsightService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private GlossaryService $glossaryService;
    private InsightService $insightService;

    /**
     * DashboardController constructor.
     *
     * @param \App\Services\GlossaryService $glossaryService
     * @param \App\Services\InsightService $insightService
     */
    public function __construct(
        GlossaryService $glossaryService,
        InsightService $insightService
    ) {
        $this->glossaryService = $glossaryService;
        $this->insightService = $insightService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $searchParameters = [];
        $searchParameters['status'] = 'unpublished';
        $unpublishedGlossaryTerms = $this->glossaryService->getGlossaries(100, $searchParameters)->all();

        $latestInsights = $this->insightService->getLatestInsights(5);

        return view('dashboard.index', [
            'unpublishedGlossaryTerms' => $unpublishedGlossaryTerms,
            'latestInsights' => $latestInsights,
        ]);
    }
}
