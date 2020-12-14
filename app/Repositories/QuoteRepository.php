<?php

namespace App\Repositories;

use App\Models\Quote;

class QuoteRepository {

    /**
     * Get all Quote terms.
     *
     * @return iterable
     */
    public function getAll()
    {
        return Quote::all();
    }

    /**
     * Get Quote term by id
     *
     * @param int $id
     * @return Quote
     */
    public function getById(int $id)
    {
        return Quote::findOrFail($id);
    }

    /**
     * Store Quote term
     *
     * @param $data
     * @return Quote
     */
    public function store($data)
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
     * @param $data
     * @param int $id
     * @return Quote
     */
    public function update($data, int $id)
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
    public function delete(int $id)
    {
        Quote::destroy($id);
    }
}