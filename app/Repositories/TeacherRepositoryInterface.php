<?php

namespace App\Repositories;

use App\Models\Teacher;

interface TeacherRepositoryInterface {

    /**
     * Get all Teachers.
     *
     * @return iterable
     */
    public function getAll(int $recordsPerPage = NULL);

    /**
     * Get Teacher by id
     *
     * @param int $id
     *
     * @return Teacher
     */
    public function getById(int $id);

    /**
     * Store Teacher
     *
     * @param $data
     *
     * @return Teacher
     */
    public function store($data);

    /**
     * Update Teacher
     *
     * @param $data
     * @param int $id
     *
     * @return Teacher
     */
    public function update($data, int $id);

    /**
     * Delete Teacher
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}