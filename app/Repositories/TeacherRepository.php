<?php

namespace App\Repositories;

use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TeacherRepository implements TeacherRepositoryInterface
{

    /**
     * Get all Teachers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \App\Models\Teacher[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Teacher::orderBy('created_at', 'desc');

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


        /*if ($recordsPerPage) {
            return Teacher::paginate($recordsPerPage);
        }
        return Teacher::all();*/
    }

    /**
     * Get Teacher by id
     *
     * @param int $id
     *
     * @return Teacher
     */
    public function getById(int $id)
    {
        return Teacher::findOrFail($id);
    }

    /**
     * Store Teacher
     *
     * @param $data
     *
     * @return Teacher
     */
    public function store($data)
    {
        $teacher = new Teacher();

        $teacher->user_id = Auth::id();
        $teacher->country_id = $data['country_id'];

        $teacher->name = $data['name'];
        $teacher->surname = $data['surname'];

        $teacher->bio = $data['bio'];
        $teacher->year_starting_practice = $data['year_starting_practice'];
        $teacher->year_starting_teach = $data['year_starting_teach'];
        $teacher->significant_teachers = $data['significant_teachers'];
        $teacher->website = $data['website'];
        $teacher->facebook = $data['facebook'];

        $teacher->save();

        return $teacher->fresh();
    }

    /**
     * Update Teacher
     *
     * @param $data
     * @param int $id
     *
     * @return Teacher
     */
    public function update($data, int $id)
    {
        $teacher = $this->getById($id);

        $teacher->country_id = $data['country_id'];

        $teacher->name = $data['name'];
        $teacher->surname = $data['surname'];

        $teacher->bio = $data['bio'];
        $teacher->year_starting_practice = $data['year_starting_practice'];
        $teacher->year_starting_teach = $data['year_starting_teach'];
        $teacher->significant_teachers = $data['significant_teachers'];
        $teacher->website = $data['website'];
        $teacher->facebook = $data['facebook'];

        $teacher->update();

        return $teacher;
    }

    /**
     * Delete Teacher
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        Teacher::destroy($id);
    }
}
