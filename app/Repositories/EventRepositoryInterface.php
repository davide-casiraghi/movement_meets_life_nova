<?php

namespace App\Repositories;

use App\Http\Requests\EventStoreRequest;
use App\Models\Event;

interface EventRepositoryInterface {

    /**
     * Get all Events.
     *
     * @return \App\Models\Event[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = NULL);

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
     * @param \App\Http\Requests\EventStoreRequest $data
     *
     * @return Event
     */
    public function store(EventStoreRequest $data);

    /**
     * Update Event
     *
     * @param \App\Http\Requests\EventStoreRequest $data
     * @param int $id
     *
     * @return Event
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function update(EventStoreRequest $data, int $id);

    /**
     * Delete Event
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}