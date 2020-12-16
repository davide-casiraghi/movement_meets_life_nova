<?php

namespace App\Repositories;

use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class TeacherRepository {

    /**
     * Get all Teachers.
     *
     * @return iterable
     */
    public function getAll(int $recordsPerPage = null)
    {
        if($recordsPerPage){
            return Teacher::paginate($recordsPerPage);
        }
        return Teacher::all();
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