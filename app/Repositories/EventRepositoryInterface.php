<?php

namespace App\Repositories;

use App\Models\Event;

interface EventRepositoryInterface
{

    /**
     * Get all Events.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \App\Models\Event[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(
        int $recordsPerPage = null,
        array $searchParameters = null
    );

    /**
     * Get Event by id
     *
     * @param $eventId
     *
     * @return Event
     */
    public function getById($eventId);

    /**
     * Store Event
     *
     * @param array $data
     *
     * @return Event
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(array $data): Event;

    /**
     * Update Event
     *
     * @param array $data
     * @param int $id
     *
     * @return Event
     */
    public function update(array $data, int $id): Event;

    /**
     * Delete Event
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}