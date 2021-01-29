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
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();
        return view('quotes.create', [
            'countriesAvailableForTranslations' => $countriesAvailableForTranslations,
        ]);
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
        $quote = $this->quoteService->createQuote($request->all());

        return redirect()->route('quotes.index')
            ->with('success', 'Quote created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $quoteId
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $quoteId)
    {
        $quote = $this->quoteService->getById($quoteId);
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        return view('quotes.edit', [
            'quote' => $quote,
            'countriesAvailableForTranslations' => $countriesAvailableForTranslations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\QuoteStoreRequest $request
     * @param int $quoteId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuoteStoreRequest $request, int $quoteId)
    {
        $quote = $this->quoteService->updateQuote($request->all(), $quoteId);

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
        $this->quoteService->deleteQuote($quoteId);

        return redirect()->route('quotes.index')
            ->with('success', 'Quote deleted successfully');
    }



}
