<?php

namespace App\Repositories;

use App\Models\Quote;

interface QuoteRepositoryInterface {

    /**
     * Get all Quote terms.
     *
     * @return iterable
     */
    public function getAll();

    /**
     * Get Quote term by id
     *
     * @param int $id
     *
     * @return Quote
     */
    public function getById(int $id);

    /**
     * Store Quote term
     *
     * @param $data
     *
     * @return Quote
     */
    public function store($data);

    /**
     * Update Quote term
     *
     * @param $data
     * @param int $id
     *
     * @return Quote
     */
    public function update($data, int $id);

    /**
     * Delete Quote term
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}