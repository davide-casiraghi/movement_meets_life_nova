<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherStoreRequest;
use App\Services\CountryService;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private $teacherService;
    private $countryService;

    public function __construct(
        TeacherService $teacherService,
        CountryService $countryService
    )
    {
        $this->teacherService = $teacherService;
        $this->countryService = $countryService;
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
        $countries = $this->countryService->getCountries();

        return view('teachers.create', [
            'countries' => $countries,
        ]);
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
        $countries = $this->countryService->getCountries();

        return view('teachers.edit', [
            'teacher' => $teacher,
            'countries' => $countries,
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
