<?php

namespace App\Repositories;

use App\Models\Organizer;

interface OrganizerRepositoryInterface {

    /**
     * Get all Organizers.
     *
     * @return iterable
     */
    public function getAll(int $recordsPerPage = NULL);

    /**
     * Get Organizer by id
     *
     * @param int $id
     *
     * @return Organizer
     */
    public function getById(int $id);

    /**
     * Store Organizer
     *
     * @param $data
     *
     * @return Organizer
     */
    public function store($data);

    /**
     * Update Organizer
     *
     * @param $data
     * @param int $id
     *
     * @return Organizer
     */
    public function update($data, int $id);

    /**
     * Delete Organizer
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}