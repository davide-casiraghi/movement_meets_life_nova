<?php

namespace App\Repositories;

use App\Models\Organizer;
use Illuminate\Support\Facades\Auth;

class OrganizerRepository implements OrganizerRepositoryInterface
{

    /**
     * Get all Organizers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \App\Models\Organizer[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Organizer::orderBy('created_at', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['name'])) {
                $query->where(
                    'name',
                    'like',
                    '%' . $searchParameters['name'] . '%'
                );
            }
            if (!empty($searchParameters['surname'])) {
                $query->where(
                    'surname',
                    'like',
                    '%' . $searchParameters['surname'] . '%'
                );
            }
            if (!empty($searchParameters['email'])) {
                $query->where(
                    'email',
                    'like',
                    '%' . $searchParameters['email'] . '%'
                );
            }
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage);
        } else {
            $results = $query->get();
        }

        return $results;

        /*if ($recordsPerPage) {
            return Organizer::paginate($recordsPerPage);
        }
        return Organizer::all();*/
    }

    /**
     * Get Organizer by id
     *
     * @param int $id
     *
     * @return Organizer
     */
    public function getById(int $id)
    {
        return Organizer::findOrFail($id);
    }

    /**
     * Store Organizer
     *
     * @param $data
     *
     * @return Organizer
     */
    public function store($data)
    {
        $organizer = new Organizer();
        $organizer->user_id = Auth::id();

        $organizer->name = $data['name'];
        $organizer->surname = $data['surname'];

        $organizer->email = $data['email'];
        $organizer->description = $data['description'];
        $organizer->website = $data['website'];
        $organizer->facebook = $data['facebook'];
        $organizer->phone = $data['phone'];

        $organizer->save();

        return $organizer->fresh();
    }

    /**
     * Update Organizer
     *
     * @param $data
     * @param int $id
     *
     * @return Organizer
     */
    public function update($data, int $id)
    {
        $organizer = $this->getById($id);

        $organizer->name = $data['name'];
        $organizer->surname = $data['surname'];

        $organizer->email = $data['email'];
        $organizer->description = $data['description'];
        $organizer->website = $data['website'];
        $organizer->facebook = $data['facebook'];
        $organizer->phone = $data['phone'];

        $organizer->update();

        return $organizer;
    }

    /**
     * Delete Organizer
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        Organizer::destroy($id);
    }
}
