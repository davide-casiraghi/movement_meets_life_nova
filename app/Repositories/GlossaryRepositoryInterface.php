<?php

namespace App\Repositories;

use App\Models\Glossary;

interface GlossaryRepositoryInterface
{

    /**
     * Get all Glossary terms.
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
     * Get Glossary term by id
     *
     * @param int $id
     *
     * @return Glossary
     */
    public function getById(int $id): Glossary;

    /**
     * Store Glossary term
     *
     * @param array $data
     *
     * @return Glossary
     */
    public function store(array $data): Glossary;

    /**
     * Update Glossary term
     *
     * @param array $data
     * @param int $id
     *
     * @return Glossary
     */
    public function update(array $data, int $id): Glossary;

    /**
     * Delete Glossary term
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Glossary $glossary
     * @param array $data
     *
     * @return \App\Models\Glossary
     */
    public function assignDataAttributes(
        Glossary $glossary,
        array $data
    ): Glossary;

    /**
     * Get glossary term by slug
     *
     * @param  string  $glossarySlug
     * @return Glossary
     */
    public function getBySlug(string $glossarySlug): ?Glossary;

}
