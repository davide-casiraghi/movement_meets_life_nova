<?php

namespace App\Http\Livewire;

use App\Models\Teacher;
use App\Repositories\TeacherRepository;
use App\Services\CountryService;
use App\Services\TeacherService;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddTeacher extends Component
{
    use WithFileUploads;

    public $teachers;
    public $selected;
    public $showModal = false;
    public $newTeacher;
    public $profilePicture;

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
        'profilePicture' => ['nullable'], // 5MB Max - , 'image','mimes:jpg,jpeg,png','max:5120'
    ];

    protected $listeners = [
        'fileUpload' => 'handleFileUpload',
    ];

    public function handleFileUpload($imageData)
    {
        $this->profilePicture = $imageData;
    }

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

    /**
     * Open the modal
     */
    public function openModal(): void
    {
        $this->teacher = new Teacher();
        $this->showModal = true;
    }

    /**
     * Close the modal
     */
    public function close(): void
    {
        $this->showModal = false;
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function saveTeacher()
    {
        $teacherRepository = App::make(TeacherRepository::class);

        $this->validate();

        $teacher = $teacherRepository->store($this->newTeacher);


        $this->storeImage($teacher, $this->profilePicture);

        /*$this->profilePicture->store('photos');
        $this->storeImage($teacher, $this->profilePicture);*/

        //$this->photo->store('profile_picture');

        $this->selected[] = $teacher->id;
        //$this->teachers[] = $teacher;

        $this->teachers = $teacherRepository->getAll();

        $this->emit('refreshDropdown', ['teacher' => $teacher]);

        session()->flash('message', 'Teacher added successfully 😁');
        $this->showModal = false;

        $this->newTeacher = [];
    }

    /**
     * Store a the image using Spatie Media Library
     */
    public function storeImage(Teacher $teacher, $photo): void
    {
        //Check image upload strategy here
        // https://www.youtube.com/watch?v=ARFZU-q-Td8&list=PLe30vg_FG4OQ8b813BDykoYz95Zc3xUWK&index=13&ab_channel=Bitfumes
        // https://github.com/bitfumes/laravel-livewire-full-course/blob/master/resources/views/livewire/comments.blade.php
        // https://github.com/bitfumes/laravel-livewire-full-course/blob/master/app/Http/Livewire/Comments.php


        //dd($photo);
        $collectionName = 'profile_picture';
        //dd($teacher);
        if (!$photo) {
            return;
        }


        //dd($this->image);

        /*$img   = ImageManagerStatic::make($this->image)->encode('jpg');
        $name  = Str::random() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;*/


        //$file = $request->file($collectionName);

        //$this->photo->store('photos');

        //if ($file->isValid()) {
        //dd($img = Image::make($photo));

        //$img = Image::make($photo);


        //$img = base64_decode($photo);




        $base64File = $photo;

        // decode the base64 file
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));

        // save it to temporary dir first.
        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $fileData);

        // this just to help us get file info.
        $tmpFile = new File($tmpFilePath);

        $file = new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            true // Mark it as test, since the file isn't from real HTTP POST.
        );









        //dd($img);

        $teacher->addMedia($file)->toMediaCollection($collectionName);
        //}
    }


}
