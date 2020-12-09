<?php

namespace App\Repositories;

use App\Models\PostCategory;

interface PostCategoryRepositoryInterface {

    /**
     * Get all PostCategories.
     *
     * @return iterable
     */
    public function getAll();

    /**
     * Get PostCategory by id
     *
     * @param int $id
     *
     * @return PostCategory
     */
    public function getById(int $id);

    /**
     * Store PostCategory
     *
     * @param $data
     *
     * @return PostCategory
     */
    public function store($data);

    /**
     * Update PostCategory
     *
     * @param $data
     * @param int $id
     *
     * @return PostCategory
     */
    public function update($data, int $id);

    /**
     * Delete PostCategory
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}