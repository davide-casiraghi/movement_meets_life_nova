<?php

namespace App\Services;

use App\Http\Requests\QuoteSearchRequest;
use App\Http\Requests\QuoteStoreRequest;
use App\Models\Quote;
use App\Repositories\QuoteRepository;
use Carbon\Carbon;

class QuoteService
{
    private QuoteRepository $quoteRepository;

    /**
     * QuoteService constructor.
     *
     * @param \App\Repositories\QuoteRepository $quoteRepository
     */
    public function __construct(
        QuoteRepository $quoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * Return the team from the database
     *
     * @param int $quoteId
     *
     * @return \App\Models\Quote
     */
    public function getById(int $quoteId): Quote
    {
        return $this->quoteRepository->getById($quoteId);
    }

    /**
     * Get all the quotes
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getQuotes(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->quoteRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Create a quote
     *
     * @param \App\Http\Requests\QuoteStoreRequest $request
     *
     * @return \App\Models\Quote
     */
    public function createQuote(QuoteStoreRequest $request): Quote
    {
        $quote = $this->quoteRepository->store($request->all());

        return $quote;
    }

    /**
     * Update the Quote
     *
     * @param \App\Http\Requests\QuoteStoreRequest $request
     * @param int $quoteId
     *
     * @return \App\Models\Quote
     */
    public function updateQuote(QuoteStoreRequest $request, int $quoteId): Quote
    {
        $quote = $this->quoteRepository->update($request->all(), $quoteId);

        return $quote;
    }

    /**
     * Delete the quote from the database
     *
     * @param int $quoteId
     */
    public function deleteQuote(int $quoteId): void
    {
        $this->quoteRepository->delete($quoteId);
    }

    /**
     *  Return the quote of the day.
     *  And set the quote to shown, so it will not be show it again in the
     *  next days until all the others has been shown.
     *
     * @param string $where - 'frontend' or 'backend'
     *
     * @return \App\Models\Quote
     */
    public function getQuoteOfTheDay(string $where): ?Quote
    {
        $today = Carbon::today();

        $quote = Quote::where('show_where', $where)
                        ->orWhere('show_where', 'both')
                        ->where(function ($query) use ($today) {
                            $query->where('shown_on', $today) //Quote already picked today
                                  ->orWhere('shown', 0);
                        })->first();

        // Reset the quotes shown when all the quotes has already been shown
        if ($quote == null) {
            Quote::whereIn('show_where', [$where, 'both'])->update(['shown' => 0,'shown_on' => null]);
            $quote = self::getQuoteOfTheDay($where);
        }

        $quote->shown = 1;
        $quote->shown_on = $today;
        $quote->save();

        return $quote;
    }
}
