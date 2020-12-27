<?php


namespace App\Repositories;

use App\Models\EventCategory;


class EventCategoryRepository implements EventCategoryRepositoryInterface {

    /**
     * Get all EventCategories.
     *
     * @return iterable
     */
    public function getAll()
    {
        return EventCategory::all();
    }

    /**
     * Get EventCategory by id
     *
     * @param int $id
     * @return EventCategory
     */
    public function getById(int $id)
    {
        return EventCategory::findOrFail($id);
    }

    /**
     * Store EventCategory
     *
     * @param $data
     * @return EventCategory
     */
    public function store($data)
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
    public function update($data, int $id)
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
    public function delete(int $id)
    {
        EventCategory::destroy($id);
    }
}