<?php

namespace App\Repositories;

use App\Models\Venue;

interface VenueRepositoryInterface {

    /**
     * Get all EventCategories.
     *
     * @return iterable
     */
    public function getAll(int $recordsPerPage = NULL);

    /**
     * Get Venue by id
     *
     * @param int $id
     *
     * @return Venue
     */
    public function getById(int $id);

    /**
     * Store Venue
     *
     * @param $data
     *
     * @return Venue
     */
    public function store($data);

    /**
     * Update Venue
     *
     * @param $data
     * @param int $id
     *
     * @return Venue
     */
    public function update($data, int $id);

    /**
     * Delete Venue
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}