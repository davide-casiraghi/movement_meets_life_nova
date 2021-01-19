<?php


namespace App\Repositories;

use App\Models\EventCategory;
use Illuminate\Support\Collection;


class EventCategoryRepository implements EventCategoryRepositoryInterface {

    /**
     * Get all EventCategories.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAll(): Collection
    {
        return EventCategory::orderBy('name')->get();
    }

    /**
     * Get EventCategory by id
     *
     * @param int $id
     * @return EventCategory
     */
    public function getById(int $id): EventCategory
    {
        return EventCategory::findOrFail($id);
    }

    /**
     * Store EventCategory
     *
     * @param $data
     * @return EventCategory
     */
    public function store($data): EventCategory
    {
        $eventCategory = new EventCategory();
        $eventCategory->name = $data['name'];
        $eventCategory->description = $data['description'];

        $eventCategory->save();

        return $eventCategory->fresh();
    }

    /**
     * Update EventCategory
     *
     * @param $data
     * @param int $id
     * @return EventCategory
     */
    public function update($data, int $id): EventCategory
    {
        $eventCategory = $this->getById($id);
        $eventCategory->name = $data['name'];
        $eventCategory->description = $data['description'];

        $eventCategory->update();

        return $eventCategory;
    }

    /**
     * Delete EventCategory
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        EventCategory::destroy($id);
    }
}