<?php
namespace App\Services;

use App\Http\Requests\EventRepetitionStoreRequest;
use App\Http\Requests\EventStoreRequest;
use App\Models\EventRepetition;
use App\Repositories\EventRepetitionRepository;

class EventRepetitionService {
    private $eventRepetitionRepository;

    public function __construct(
        EventRepetitionRepository $eventRepetitionRepository

    ) {
        $this->eventRepetitionRepository = $eventRepetitionRepository;
    }

    /**
     * Create a eventRepetition
     *
     * @param \App\Http\Requests\EventRepetitionStoreRequest $data
     *
     * @return \App\Models\EventRepetition
     */
    public function createEventRepetition(EventRepetitionStoreRequest $data)
    {
        $eventRepetition = $this->eventRepetitionRepository->store($data);

        return $eventRepetition;
    }

    /**
     * Update the EventRepetition
     *
     * @param \App\Http\Requests\EventStoreRequest $data
     * @param int $eventRepetitionId
     *
     * @return void
     */
    public function updateEventRepetitions(EventStoreRequest $data, int $eventRepetitionId)
    {
        $this->eventRepetitionRepository->updateEventRepetitions($data, $eventRepetitionId);

        //return $eventRepetition;
    }

    /**
     * Return the eventRepetition from the database
     *
     * @param $eventRepetitionId
     *
     * @return \App\Models\EventRepetition
     */
    public function getById(int $eventRepetitionId)
    {
        return $this->eventRepetitionRepository->getById($eventRepetitionId);
    }

    /**
     * Get all the EventRepetitions.
     *
     * @return iterable
     */
    public function getEventRepetitions()
    {
        return $this->eventRepetitionRepository->getAll();
    }

    /**
     * Delete the eventRepetition from the database
     *
     * @param int $eventRepetitionId
     */
    public function deleteEventRepetition(int $eventRepetitionId): void
    {
        $this->eventRepetitionRepository->delete($eventRepetitionId);
    }

   

    

    /**
     * Get the event first repetition
     *
     * @param $eventId
     *
     * @return EventRepetition
     */
    public function getFirstByEventId($eventId)
    {
        return $this->eventRepetitionRepository->getFirstByEventId($eventId);
    }



}