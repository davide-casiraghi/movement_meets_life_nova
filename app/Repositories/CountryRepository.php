<?php


namespace App\Repositories;

use App\Models\Country;


class CountryRepository  {

    /**
     * Get all PostCategories.
     *
     * @return iterable
     */
    public function getAll()
    {
        return Country::all();
    }

    /**
     * Get Country by id
     *
     * @param int $id
     * @return Country
     */
    public function getById(int $id)
    {
        return Country::findOrFail($id);
    }

    /**
     * Store Country
     *
     * @param $data
     * @return Country
     */
    public function store($data)
    {
        $country = new Country();
        $country->name = $data['name'];
        $country->code = $data['code'];
        $country->continent_id = $data['continent_id'];

        $country->save();

        return $country->fresh();
    }

    /**
     * Update Country
     *
     * @param $data
     * @param int $id
     * @return Country
     */
    public function update($data, int $id)
    {
        $country = $this->getById($id);
        $country->name = $data['name'];
        $country->code = $data['code'];
        $country->continent_id = $data['continent_id'];

        $country->update();

        return $country;
    }

    /**
     * Delete Country
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        Country::destroy($id);
    }
}