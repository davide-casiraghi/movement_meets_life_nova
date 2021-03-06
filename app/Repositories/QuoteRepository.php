<?php

namespace App\Repositories;

use App\Models\Quote;
use Illuminate\Support\Facades\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class QuoteRepository implements QuoteRepositoryInterface
{

    /**
     * Get all Quote terms.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Quote::orderBy('created_at', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['author'])) {
                $query->where(
                    'author',
                    'like',
                    '%' . $searchParameters['author'] . '%'
                );
            }
            if (!empty($searchParameters['description'])) {
                $query->where(
                    'description',
                    'like',
                    '%' . $searchParameters['description'] . '%'
                );
            }
            if (!is_null($searchParameters['is_published'])) {
                $query->where('is_published', $searchParameters['is_published']);
            }
            if (!is_null($searchParameters['show_where'])) {
                $query->where('show_where', $searchParameters['show_where']);
            }
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage)->withQueryString();
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get Quote term by id
     *
     * @param int $id
     * @return Quote
     */
    public function getById(int $id): Quote
    {
        return Quote::findOrFail($id);
    }

    /**
     * Store Quote term
     *
     * @param array $data
     * @return Quote
     */
    public function store(array $data): Quote
    {
        $quote = new Quote();
        $quote = self::assignDataAttributes($quote, $data);

        $quote->save();

        return $quote->fresh();
    }

    /**
     * Update Quote term
     *
     * @param array $data
     * @param int $id
     * @return Quote
     */
    public function update(array $data, int $id): Quote
    {
        $quote = $this->getById($id);
        $quote = self::assignDataAttributes($quote, $data);

        $quote->update();

        return $quote;
    }

    /**
     * Delete Quote term
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Quote::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Quote $quote
     * @param array $data
     *
     * @return \App\Models\Quote
     */
    public function assignDataAttributes(Quote $quote, array $data): Quote
    {
        $quote->author = $data['author'];
        $quote->description = $data['description'];
        $quote->is_published = (isset($data['is_published'])) ? 1 : 0;
        $quote->show_where = $data['show_where'];

        // Translations
        foreach (LaravelLocalization::getSupportedLocales() as $countryCode => $countryAvTrans) {
            if ($countryCode != Config::get('app.fallback_locale')) {
                $quote->setTranslation('description', $countryCode, $data['description_' . $countryCode] ?? null);
            }
        }

        return $quote;
    }
}
