<?php


namespace App\Repositories;

use App\Models\EventVenue;


class EventVenueRepository {

    /**
     * Get all EventCategories.
     *
     * @return iterable
     */
    public function getAll()
    {
        return EventVenue::all();
    }

    /**
     * Get EventVenue by id
     *
     * @param int $id
     * @return EventVenue
     */
    public function getById(int $id)
    {
        return EventVenue::findOrFail($id);
    }

    /**
     * Store EventVenue
     *
     * @param $data
     * @return EventVenue
     */
    public function store($data)
    {
        $eventVenue = new EventVenue();

        $eventVenue->name = $data['name'];
        $eventVenue->description = $data['description'];
        $eventVenue->website = $data['website'];
        $eventVenue->extra_info = $data['extra_info'];
        $eventVenue->address = $data['address'];
        $eventVenue->city = $data['city'];
        $eventVenue->state_province = $data['state_province'];
        $eventVenue->country = $data['country'];
        $eventVenue->zip_code = $data['zip_code'];
        $eventVenue->lng = $data['lng'];
        $eventVenue->lng = $data['lng'];

        $eventVenue->save();

        return $eventVenue->fresh();
    }

    /**
     * Update EventVenue
     *
     * @param $data
     * @param int $id
     * @return EventVenue
     */
    public function update($data, int $id)
    {
        $eventVenue = $this->getById($id);

        $eventVenue->name = $data['name'];
        $eventVenue->description = $data['description'];
        $eventVenue->website = $data['website'];
        $eventVenue->extra_info = $data['extra_info'];
        $eventVenue->address = $data['address'];
        $eventVenue->city = $data['city'];
        $eventVenue->state_province = $data['state_province'];
        $eventVenue->country = $data['country'];
        $eventVenue->zip_code = $data['zip_code'];
        $eventVenue->lng = $data['lng'];
        $eventVenue->lng = $data['lng'];

        $eventVenue->update();

        return $eventVenue;
    }

    /**
     * Delete EventVenue
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        EventVenue::destroy($id);
    }
}