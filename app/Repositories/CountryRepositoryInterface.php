<?php

namespace App\Repositories;

use App\Models\Country;

interface CountryRepositoryInterface {

    /**
     * Get all PostCategories.
     *
     * @return iterable
     */
    public function getAll();

    /**
     * Get Country by id
     *
     * @param int $id
     *
     * @return Country
     */
    public function getById(int $id);

    /**
     * Store Country
     *
     * @param $data
     *
     * @return Country
     */
    public function store($data);

    /**
     * Update Country
     *
     * @param $data
     * @param int $id
     *
     * @return Country
     */
    public function update($data, int $id);

    /**
     * Delete Country
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}