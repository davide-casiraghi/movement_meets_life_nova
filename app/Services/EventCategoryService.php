<?php

namespace App\Services;

use App\Http\Requests\EventCategoryStoreRequest;
use App\Repositories\EventCategoryRepository;

class EventCategoryService {

    private EventCategoryRepository $eventCategoryRepository;

    /**
     * EventCategoryService constructor.
     *
     * @param \App\Repositories\EventCategoryRepository $eventCategoryRepository
     */
    public function __construct(
        EventCategoryRepository $eventCategoryRepository
    ) {
        $this->eventCategoryRepository = $eventCategoryRepository;
    }

    /**
     * Create a EventCategory
     *
     * @param \App\Http\Requests\EventCategoryStoreRequest $data
     *
     * @return \App\Models\EventCategory
     */
    public function createEventCategory(EventCategoryStoreRequest $data)
    {
        $eventCategory = $this->eventCategoryRepository->store($data);

        return $eventCategory;
    }

    /**
     * Update the EventCategory
     *
     * @param \App\Http\Requests\EventCategoryStoreRequest $data
     * @param int $eventCategoryId
     *
     * @return \App\Models\EventCategory
     */
    public function updateEventCategory(EventCategoryStoreRequest $data, int $eventCategoryId)
    {
        $eventCategory = $this->eventCategoryRepository->update($data, $eventCategoryId);

        return $eventCategory;
    }

    /**
     * Return the EventCategory from the database
     *
     * @param int $eventCategoryId
     *
     * @return \App\Models\EventCategory
     */
    public function getById(int $eventCategoryId)
    {
        return $this->eventCategoryRepository->getById($eventCategoryId);
    }

    /**
     * Get all the EventCategories
     *
     * @return iterable
     */
    public function getEventCategories()
    {
        return $this->eventCategoryRepository->getAll();
    }

    /**
     * Delete the EventCategory from the database
     *
     * @param int $eventCategoryId
     */
    public function deleteEventCategory(int $eventCategoryId): void
    {
        $this->eventCategoryRepository->delete($eventCategoryId);
    }

}