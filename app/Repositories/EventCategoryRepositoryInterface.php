<?php

namespace App\Repositories;

use App\Models\EventCategory;

interface EventCategoryRepositoryInterface {

    /**
     * Get all EventCategories.
     *
     * @return iterable
     */
    public function getAll();

    /**
     * Get EventCategory by id
     *
     * @param int $id
     *
     * @return EventCategory
     */
    public function getById(int $id);

    /**
     * Store EventCategory
     *
     * @param $data
     *
     * @return EventCategory
     */
    public function store($data);

    /**
     * Update EventCategory
     *
     * @param $data
     * @param int $id
     *
     * @return EventCategory
     */
    public function update($data, int $id);

    /**
     * Delete EventCategory
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}