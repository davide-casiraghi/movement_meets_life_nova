<?php

namespace App\Repositories;

use App\Models\Venue;

class VenueRepository implements VenueRepositoryInterface
{

    /**
     * Get all EventCategories.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \App\Models\Venue[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Venue::orderBy('created_at', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['name'])) {
                $query->where(
                    'name',
                    'like',
                    '%' . $searchParameters['name'] . '%'
                );
            }
            if (!empty($searchParameters['city'])) {
                $query->where(
                    'city',
                    'like',
                    '%' . $searchParameters['city'] . '%'
                );
            }
            if (!empty($searchParameters['countryId'])) {
                $query->where('country_id', $searchParameters['countryId']);
            }
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage);
        } else {
            $results = $query->get();
        }

        return $results;

        /*if($recordsPerPage){
            return Venue::paginate($recordsPerPage);
        }
        return Venue::all();*/
    }

    /**
     * Get Venue by id
     *
     * @param int $id
     *
     * @return Venue
     */
    public function getById(int $id)
    {
        return Venue::findOrFail($id);
    }

    /**
     * Store Venue
     *
     * @param $data
     *
     * @return Venue
     */
    public function store($data)
    {
        $venue = new Venue();

        $venue->name = $data['name'];
        $venue->description = $data['description'];
        $venue->website = $data['website'];
        $venue->extra_info = $data['extra_info'];
        $venue->address = $data['address'];
        $venue->city = $data['city'];
        $venue->state_province = $data['state_province'];
        $venue->country = $data['country'];
        $venue->zip_code = $data['zip_code'];
        $venue->lng = $data['lng'];
        $venue->lng = $data['lng'];

        $venue->save();

        return $venue->fresh();
    }

    /**
     * Update Venue
     *
     * @param $data
     * @param int $id
     *
     * @return Venue
     */
    public function update($data, int $id)
    {
        $venue = $this->getById($id);

        $venue->name = $data['name'];
        $venue->description = $data['description'];
        $venue->website = $data['website'];
        $venue->extra_info = $data['extra_info'];
        $venue->address = $data['address'];
        $venue->city = $data['city'];
        $venue->state_province = $data['state_province'];
        $venue->country = $data['country'];
        $venue->zip_code = $data['zip_code'];
        $venue->lng = $data['lng'];
        $venue->lng = $data['lng'];

        $venue->update();

        return $venue;
    }

    /**
     * Delete Venue
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        Venue::destroy($id);
    }
}
