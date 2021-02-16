<?php

namespace App\Http\Controllers;

use App\Models\Glossary;
use App\Services\GlossaryService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private GlossaryService $glossaryService;

    /**
     * DashboardController constructor.
     *
     * @param \App\Services\GlossaryService $glossaryService
     */
    public function __construct(
        GlossaryService $glossaryService
    ) {
        $this->glossaryService = $glossaryService;
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

        return view('dashboard.index', [
            'unpublishedGlossaryTerms' => $unpublishedGlossaryTerms,
        ]);
    }
}
