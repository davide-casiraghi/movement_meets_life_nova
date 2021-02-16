<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\GlossarySearchRequest;
use App\Http\Requests\GlossaryStoreRequest;
use App\Models\Glossary;
use App\Services\GlossaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GlossaryController extends Controller
{
    private GlossaryService $glossaryService;

    /**
     * GlossaryController constructor.
     *
     * @param \App\Services\GlossaryService $glossaryService
     */
    public function __construct(
        GlossaryService $glossaryService
    ) {
        $this->glossaryService = $glossaryService;
    }

    /**
     * Show the resource.
     *
     * @param int $glossaryTermId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function show(int $glossaryTermId): View
    {
        $glossaryTerm = Glossary::find($glossaryTermId);

        return view('glossaries.show', [
            'glossaryTerm' => $glossaryTerm,
            //'posts' => $posts,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\GlossarySearchRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(GlossarySearchRequest $request): View
    {
        $searchParameters = Helper::getSearchParameters($request, Glossary::SEARCH_PARAMETERS);
        $glossaries = $this->glossaryService->getGlossaries(20, $searchParameters);
        $statuses = Glossary::PUBLISHING_STATUS;

        return view('glossaries.index', [
            'glossaries' => $glossaries,
            'searchParameters' => $searchParameters,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create(): View
    {
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();
        return view('glossaries.create', [
            'countriesAvailableForTranslations' => $countriesAvailableForTranslations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\GlossaryStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GlossaryStoreRequest $request): RedirectResponse
    {
        $this->glossaryService->createGlossary($request);

        return redirect()->route('glossaries.index')
            ->with('success', 'Tag created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $glossaryId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(int $glossaryId): View
    {
        $glossary = $this->glossaryService->getById($glossaryId);
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        return view('glossaries.edit', [
            'glossary' => $glossary,
            'countriesAvailableForTranslations' => $countriesAvailableForTranslations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\GlossaryStoreRequest $request
     * @param int $glossaryId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GlossaryStoreRequest $request, int $glossaryId): RedirectResponse
    {
        $this->glossaryService->updateGlossary($request, $glossaryId);

        return redirect()->route('glossaries.index')
            ->with('success', 'Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $glossaryId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $glossaryId): RedirectResponse
    {
        $this->glossaryService->deleteGlossary($glossaryId);

        return redirect()->route('glossaries.index')
            ->with('success', 'Tag deleted successfully');
    }
}
