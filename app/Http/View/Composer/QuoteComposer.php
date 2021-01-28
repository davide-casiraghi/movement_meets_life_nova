<?php
namespace App\Http\View\Composer;

use Illuminate\View\View;
use App\Services\QuoteService;

class QuoteComposer
{
    private QuoteService $quoteService;

    public function __construct(
        QuoteService $quoteService
    ) {
        $this->quoteService = $quoteService;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('quote', $this->quoteService->getQuoteOfTheDay());
    }
}
