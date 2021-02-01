<?php

namespace App\Repositories;

use App\Models\Tag;

interface TagRepositoryInterface
{

    /**
     * Get all Tags.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(
        int $recordsPerPage = null,
        array $searchParameters = null
    );

    /**
     * Get Tag by id
     *
     * @param int $id
     *
     * @return Tag
     */
    public function getById(int $id): Tag;

    /**
     * Store Tag
     *
     * @param array $data
     *
     * @return Tag
     */
    public function store(array $data): Tag;

    /**
     * Update Tag
     *
     * @param array $data
     * @param int $id
     *
     * @return Tag
     */
    public function update(array $data, int $id): Tag;

    /**
     * Delete Tag
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;

}