<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GalleryImagesParameters extends Component
{
    public $model;
    public $image;

    public $image_description;
    public $image_video_url;
    public $image_gallery; // The name of the gallery to assign the image to

    public $galleries;

    public $showModal = false;

    protected $rules = [
        'image_description' => 'string',
        'image_video_url' => 'string',
        'image_gallery' => 'string',
    ];

    public function mount($model)
    {
        $this->model = $model;
    }

    public function render()
    {
        self::getGalleryNames();

        return view('livewire.gallery-images-parameters');
    }

    public function edit($imageId)
    {
        $this->showModal = true;
        $this->image = Media::find($imageId);

        $this->image_description = $this->image->getCustomProperty('image_description');
        $this->image_video_url = $this->image->getCustomProperty('image_video_url');
        $this->image_gallery = $this->image->getCustomProperty('image_gallery');
    }

    public function save()
    {
        $this->image->setCustomProperty('image_description', $this->image_description);
        $this->image->setCustomProperty('image_video_url', $this->image_video_url);
        $this->image->setCustomProperty('image_gallery', lcfirst($this->image_gallery));
        $this->image->save();

        $this->showModal = false;
    }

    public function close()
    {
        $this->showModal = false;
    }


    public function getGalleryNames()
    {
        $galleries = [];
        foreach ($this->model->getMedia('images') as $image) {
            $galleries[$image->getCustomProperty('image_gallery')] = $image->getCustomProperty('image_gallery');
        }
        $this->galleries = array_values($galleries);
    }
}
