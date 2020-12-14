<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherStoreRequest;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private $teacherService;

    public function __construct(
        TeacherService $teacherService
    )
    {
        $this->teacherService = $teacherService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $teachers = $this->teacherService->getTeachers(20);

        return view('teachers.index', [
            'teachers' => $teachers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TeacherStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(TeacherStoreRequest $request)
    {
        $this->teacherService->createTeacher($request);

        return redirect()->route('teachers.index')
            ->with('success','Teacher updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $teacherId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $teacherId)
    {
        $teacher = $this->teacherService->getById($teacherId);

        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $teacherId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $teacherId)
    {
        $teacher = $this->teacherService->getById($teacherId);

        return view('teachers.edit', [
            'teacher' => $teacher
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\TeacherStoreRequest $request
     * @param int $teacherId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TeacherStoreRequest $request, int $teacherId)
    {
        $this->teacherService->updateTeacher($request, $teacherId);

        return redirect()->route('teachers.index')
            ->with('success','Teacher updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $teacherId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $teacherId)
    {
        $this->teacherService->deleteTeacher($teacherId);

        return redirect()->route('teachers.index')
            ->with('success','Teacher deleted successfully');
    }
}
