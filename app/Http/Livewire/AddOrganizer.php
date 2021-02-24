<?php

namespace App\Http\Livewire;

use App\Models\Organizer;
use App\Repositories\OrganizerRepository;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Livewire\Component;

class AddOrganizer extends Component
{
    public $organizers;
    public $selected;
    public $showModal = false;
    public $newOrganizer;
    public $profilePicture;

    protected $rules = [
        'newOrganizer.name' => ['required', 'string', 'max:255'],
        'newOrganizer.surname' => ['required', 'string', 'max:255'],
        'newOrganizer.email' => ['required', 'email', 'max:255'],
        'newOrganizer.phone' => ['nullable', 'string', 'max:255'],
        'newOrganizer.website' => ['nullable', 'url'],
        'newOrganizer.description' => ['required', 'string'],
        'profilePicture' => ['nullable'], // 5MB Max - , 'image','mimes:jpg,jpeg,png','max:5120'
    ];

    protected $listeners = [
        'fileUpload' => 'handleFileUpload',
    ];

    public function handleFileUpload($imageData)
    {
        $this->profilePicture = $imageData;
    }

    /**
     * The component constructor
     */
    public function mount($organizers, $selected)
    {
        $this->organizers = $organizers;
        $this->selected = $selected;
    }

    /**
     * Default component render method
     */
    public function render()
    {
        return view('livewire.add-organizer');
    }

    /**
     * Open the modal
     */
    public function openModal(): void
    {
        $this->organizer = new Organizer();
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
     * Store a newly created organizer in storage.
     */
    public function saveOrganizer()
    {
        $organizerRepository = App::make(OrganizerRepository::class);

        $this->validate();

        $organizer = $organizerRepository->store($this->newOrganizer);

        $this->storeImage($organizer, $this->profilePicture);

        $this->selected[] = $organizer->id;
        //$this->organizers[] = $organizer;

        $this->organizers = $organizerRepository->getAll();

        $this->emit('refreshOrganizersDropdown', ['organizer' => $organizer]);

        session()->flash('message', 'Organizer added successfully 😁'); //todo - replace this flash message with a variable to set true
        $this->showModal = false;

        $this->newOrganizer = [];
    }

    /**
     * Store a the image using Spatie Media Library
     *
     * @param \App\Models\Organizer $organizer
     * @param $photo
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function storeImage(Organizer $organizer, $photo): void
    {
        //Check image upload strategy here
        // https://www.youtube.com/watch?v=ARFZU-q-Td8&list=PLe30vg_FG4OQ8b813BDykoYz95Zc3xUWK&index=13&ab_channel=Bitfumes
        // https://github.com/bitfumes/laravel-livewire-full-course/blob/master/resources/views/livewire/comments.blade.php
        // https://github.com/bitfumes/laravel-livewire-full-course/blob/master/app/Http/Livewire/Comments.php

        $collectionName = 'profile_picture';
        if (!$photo) {
            return;
        }

        $file = self::convertBase64ImageToUploadedFile($photo);

        $organizer->addMedia($file)->toMediaCollection($collectionName);
    }


    /**
     * Convert a base64 image to UploadedFile Laravel
     *
     * @param string $base64File
     *
     * @return \Illuminate\Http\UploadedFile
     */
    public function convertBase64ImageToUploadedFile(string $base64File): UploadedFile
    {
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

        return $file;
    }
}
