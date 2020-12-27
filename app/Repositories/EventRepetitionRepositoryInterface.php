<?php

namespace App\Repositories;

use App\Models\EventRepetition;

interface EventRepetitionRepositoryInterface {

    /**
     * Get all EventRepetitions.
     *
     * @return \App\Models\EventRepetition[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * Get EventRepetition by id
     *
     * @param $eventRepetitionId
     *
     * @return EventRepetition
     */
    public function getById($eventRepetitionId);

    /**
     * Get the event first repetition
     *
     * @param $eventId
     *
     * @return EventRepetition
     */
    public function getFirstByEventId($eventId);

    /**
     * To save event repetitions for create and update methods.
     *
     * @param array $data
     * @param int $eventId
     *
     * @return void
     */
    public function updateEventRepetitions(array $data, int $eventId): void;

}