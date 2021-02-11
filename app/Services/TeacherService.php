<?php
namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\TeacherSearchRequest;
use App\Http\Requests\TeacherStoreRequest;
use App\Models\Teacher;
use App\Repositories\TeacherRepository;

class TeacherService
{
    private TeacherRepository $teacherRepository;

    /**
     * TestimonialService constructor.
     *
     * @param \App\Repositories\TeacherRepository $teacherRepository
     */
    public function __construct(
        TeacherRepository $teacherRepository
    ) {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Create a teacher
     *
     * @param \App\Http\Requests\TeacherStoreRequest $request
     *
     * @return \App\Models\Teacher
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createTeacher(TeacherStoreRequest $request): Teacher
    {
        $teacher = $this->teacherRepository->store($request->all());
        ImageHelpers::storeImages($teacher, $request, 'profile_picture');

        $teacher->setStatus('published');

        return $teacher;
    }

    /**
     * Update the Teacher
     *
     * @param \App\Http\Requests\TeacherStoreRequest $request
     * @param int $teacherId
     *
     * @return \App\Models\Teacher
     */
    public function updateTeacher(TeacherStoreRequest $request, int $teacherId): Teacher
    {
        $teacher = $this->teacherRepository->update($request->all(), $teacherId);

        ImageHelpers::storeImages($teacher, $request, 'profile_picture');
        ImageHelpers::deleteImages($teacher, $request, 'profile_picture');

        return $teacher;
    }

    /**
     * Return the teacher from the database
     *
     * @param $teacherId
     *
     * @return \App\Models\Teacher
     */
    public function getById(int $teacherId): Teacher
    {
        return $this->teacherRepository->getById($teacherId);
    }

    /**
     * Get all the Teachers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getTeachers(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->teacherRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the teacher from the database
     *
     * @param int $teacherId
     */
    public function deleteTeacher(int $teacherId): void
    {
        $this->teacherRepository->delete($teacherId);
    }

    /**
     * Get the number of teacher created in the last 30 days.
     *
     * @return int
     */
    public function getNumberTeachersCreatedLastThirtyDays(): int
    {
        return Teacher::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Get the organizer search parameters
     *
     * @param \App\Http\Requests\TeacherSearchRequest $request
     *
     * @return array
     */
    public function getSearchParameters(TeacherSearchRequest $request): array
    {
        $searchParameters = [];
        $searchParameters['name'] = $request->name ?? null;
        $searchParameters['surname'] = $request->surname ?? null;
        $searchParameters['countryId'] = $request->countryId ?? null;

        return $searchParameters;
    }
}
