<?php

namespace App\Repositories;

use App\Models\Tag;

interface TagRepositoryInterface {

    /**
     * Get all Tags.
     *
     * @return iterable
     */
    public function getAll();

    /**
     * Get Tag by id
     *
     * @param int $id
     *
     * @return Tag
     */
    public function getById(int $id);

    /**
     * Store Tag
     *
     * @param $data
     *
     * @return Tag
     */
    public function store($data);

    /**
     * Update Tag
     *
     * @param $data
     * @param int $id
     *
     * @return Tag
     */
    public function update($data, int $id);

    /**
     * Delete Tag
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}