<?php

namespace App\Repositories;

use App\Models\Quote;

class QuoteRepository implements QuoteRepositoryInterface
{

    /**
     * Get all Quote terms.
     *
     * @return iterable
     */
    public function getAll(): Quote
    {
        return Quote::all();
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
        $quote->author = $data['author'];
        $quote->description = $data['description'];

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
        $quote->author = $data['author'];
        $quote->description = $data['description'];

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
}