<?php

namespace App\Http\Livewire;

use App\Models\Teacher;
use App\Repositories\TeacherRepository;
use App\Services\CountryService;
use App\Services\TeacherService;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class AddTeacher extends Component
{
    public $teachers;
    public $selected;
    public $showModal = false;
    public $newTeacher;

    protected $rules = [
        'newTeacher.country_id' => ['required', 'string'],
        'newTeacher.name' => ['required', 'string', 'max:255'],
        'newTeacher.surname' => ['required', 'string', 'max:255'],
        'newTeacher.bio' => ['required', 'string'],
        'newTeacher.year_starting_practice' => ['required', 'integer','min:1972'],
        'newTeacher.year_starting_teach' => ['required', 'integer','min:1972'],
        'newTeacher.significant_teachers' => ['required', 'string'],
        'newTeacher.facebook' => ['nullable', 'url'],
        'newTeacher.website' => ['nullable', 'url'],
    ];

    public function mount($teachers, $selected)
    {
        $this->teachers = $teachers;
        $this->selected = $selected;
    }

    public function render()
    {
        $countryService = App::make(CountryService::class);
        $countries = $countryService->getCountries();

        return view('livewire.add-teacher', ['countries' => $countries]);
    }

    public function openModal()
    {
        $this->teacher = new Teacher();
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function saveTeacher()
    {
        $teacherRepository = App::make(TeacherRepository::class);

        $this->validate();

        $teacher = $teacherRepository->store($this->newTeacher);

        $this->selected[] = $teacher->id;
        //$this->teachers[] = $teacher;

        $this->teachers = $teacherRepository->getAll();

        $this->emit('refreshDropdown', ['teacher' => $teacher]);

        session()->flash('message', 'Teacher added successfully 😁');
        $this->showModal = false;

        $this->newTeacher = [];
    }


}
