<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteSearchRequest;
use App\Http\Requests\QuoteStoreRequest;
use App\Services\QuoteService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class QuoteController extends Controller
{
    private QuoteService $quoteService;

    public function __construct(
        QuoteService $quoteService
    ) {
        $this->quoteService = $quoteService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\QuoteSearchRequest $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(QuoteSearchRequest $request)
    {
        $searchParameters = $this->quoteService->getSearchParameters($request);
        $quotes = $this->quoteService->getQuotes(20, $searchParameters);

        return view('quotes.index', [
            'quotes' => $quotes,
            'searchParameters' => $searchParameters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('quotes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\QuoteSearchRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuoteSearchRequest $request)
    {
        $this->quoteService->createTag($request);

        return redirect()->route('quotes.index')
            ->with('success', 'Quote created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $tagId
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $tagId)
    {
        $tag = $this->quoteService->getById($tagId);
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        return view('quotes.edit', [
            'tag' => $tag,
            'countriesAvailableForTranslations' => $countriesAvailableForTranslations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\QuoteStoreRequest $request
     * @param int $tagId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuoteStoreRequest $request, int $tagId)
    {
        $this->quoteService->updateTag($request, $tagId);

        return redirect()->route('quotes.index')
            ->with('success', 'Quote updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $quoteId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $quoteId)
    {
        $this->quoteService->deleteTag($quoteId);

        return redirect()->route('tags.index')
            ->with('success', 'Quote deleted successfully');
    }



}
