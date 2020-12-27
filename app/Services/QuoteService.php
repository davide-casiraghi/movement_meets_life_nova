<?php


namespace App\Services;

use App\Models\Quote;

class QuoteService {

    /**
     * Return the team from the database
     *
     * @param $quoteId
     *
     * @return \App\Models\Quote
     */
    public function getById($quoteId)
    {
        return Quote::findById($quoteId);
    }

    /**
     * Get all teams.
     *
     * @return iterable
     */
    public function getAll()
    {
        return $roles = Quote::all();
    }

    /**
     * Return a random quote
     *
     * @return \App\Models\Quote
     */
    public function getRandomQuote()
    {

        // Use the day of the year to get a daily changing
        // quote changing (z = 0 till 365)
        $DayOfTheYear = date('z');

        $quotes = Quote::all();
        return $this->randomQuoteByInterval($DayOfTheYear, $quotes);

    }

    function randomQuoteByInterval($TimeBase, $QuotesArray)
    {

        // Make sure it is a integer
        $TimeBase = intval($TimeBase);

        // How many items are in the array?
        $ItemCount = count($QuotesArray);

        // By using the modulus operator we get a pseudo
        // random index position that is between zero and the
        // maximal value (ItemCount)
        if($ItemCount > 0){
            $RandomIndexPos = ($TimeBase % $ItemCount);
            // Now return the random array element
            return $QuotesArray[$RandomIndexPos];
        }
        return null;
    }

}