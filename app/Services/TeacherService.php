<?php
namespace App\Services;

use App\Http\Requests\TeacherStoreRequest;
use App\Models\Teacher;
use App\Repositories\TeacherRepository;

class TeacherService {
    private $teacherRepository;

    public function __construct(
        TeacherRepository $teacherRepository
    ) {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Create a teacher
     *
     * @param \App\Http\Requests\TeacherStoreRequest $data
     *
     * @return \App\Models\Teacher
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createTeacher(TeacherStoreRequest $data)
    {
        $teacher = $this->teacherRepository->store($data);

        $teacher->setStatus('pending');

        $this->storeImages($teacher, $data);

        return $teacher;
    }

    /**
     * Update the Teacher
     *
     * @param \App\Http\Requests\TeacherStoreRequest $data
     * @param int $teacherId
     *
     * @return \App\Models\Teacher
     */
    public function updateTeacher(TeacherStoreRequest $data, int $teacherId)
    {
        $teacher = $this->teacherRepository->update($data, $teacherId);

        $this->storeImages($teacher, $data);

        return $teacher;
    }

    /**
     * Return the teacher from the database
     *
     * @param $teacherId
     *
     * @return \App\Models\Teacher
     */
    public function getById(int $teacherId)
    {
        return $this->teacherRepository->getById($teacherId);
    }

    /**
     * Get all the Teachers.
     *
     * @return iterable
     */
    public function getTeachers(int $recordsPerPage = null)
    {
        return $this->teacherRepository->getAll($recordsPerPage);
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
    public function getNumberTeachersCreatedLastThirtyDays()
    {
        return Teacher::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param \App\Models\Teacher $teacher
     * @param \App\Http\Requests\TeacherStoreRequest $data
     *
     * @return void
     */
    private function storeImages(Teacher $teacher, TeacherStoreRequest $data):void {
        /*if($data->file('photos')) {
            foreach ($data->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $teacher->addMedia($photo)->toMediaCollection('post');
                }
            }
        }*/

        if($data->file('introimage')) {
            $introimage = $data->file('introimage');
            if ($introimage->isValid()) {
                $teacher->addMedia($introimage)->toMediaCollection('introimage');
            }
        }

        if($data['introimage_delete'] == 'true'){
            $mediaItems = $teacher->getMedia('introimage');
            if(!is_null($mediaItems[0])){
                $mediaItems[0]->delete();
            }
        }


    }

    /**
     * Return an array with the thumb images ulrs
     *
     * @param int $teacherId
     *
     * @return array
     */
    public function getThumbsUrls(int $teacherId): array{
        $thumbUrls = [];

        $teacher = $this->getById($teacherId);
        foreach($teacher->getMedia('teacher') as $photo){
            $thumbUrls[] = $photo->getUrl('thumb');
        }

        return $thumbUrls;
    }

}