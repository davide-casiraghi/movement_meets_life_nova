<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GalleryImagesParameters extends Component
{
    public $model;
    public $image;

    public $title;
    public $description;
    public $gallery; // The name of the gallery to assign the image to

    public $showModal = false;

    protected $rules = [
        'title' => 'string',
        'description' => 'string',
        'gallery' => 'string',
    ];

    public function mount($model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.gallery-images-parameters');
    }

    public function edit($imageId)
    {
        $this->showModal = true;
        $this->image = Media::find($imageId);

        $this->title = $this->image->getCustomProperty('title');
        $this->description = $this->image->getCustomProperty('description');
        $this->gallery = $this->image->getCustomProperty('gallery');
    }

    public function save()
    {
        $this->image->setCustomProperty('title', $this->title);
        $this->image->setCustomProperty('description', $this->description);
        $this->image->setCustomProperty('gallery', lcfirst($this->gallery));
        $this->image->save();

        $this->showModal = false;
    }

    public function close()
    {
        $this->showModal = false;
    }
}
