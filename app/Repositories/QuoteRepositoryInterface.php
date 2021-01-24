<?php

namespace App\Repositories;

use App\Models\Quote;

interface QuoteRepositoryInterface
{

    /**
     * Get all Quote terms.
     *
     * @return iterable
     */
    public function getAll(): Quote;

    /**
     * Get Quote term by id
     *
     * @param int $id
     *
     * @return Quote
     */
    public function getById(int $id): Quote;

    /**
     * Store Quote term
     *
     * @param array $data
     *
     * @return Quote
     */
    public function store(array $data): Quote;

    /**
     * Update Quote term
     *
     * @param array $data
     * @param int $id
     *
     * @return Quote
     */
    public function update(array $data, int $id): Quote;

    /**
     * Delete Quote term
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;

}