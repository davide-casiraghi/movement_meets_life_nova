<?php

namespace App\Repositories;

use App\Models\Glossary;

interface GlossaryRepositoryInterface {

    /**
     * Get all Glossary terms.
     *
     * @return iterable
     */
    public function getAll();

    /**
     * Get Glossary term by id
     *
     * @param int $id
     *
     * @return Glossary
     */
    public function getById(int $id);

    /**
     * Store Glossary term
     *
     * @param $data
     *
     * @return Glossary
     */
    public function store($data);

    /**
     * Update Glossary term
     *
     * @param $data
     * @param int $id
     *
     * @return Glossary
     */
    public function update($data, int $id);

    /**
     * Delete Glossary term
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}