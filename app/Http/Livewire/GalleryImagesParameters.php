<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class GalleryImagesParameters extends Component
{
    public $model;

    public function mount($model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.gallery-images-parameters');
    }
}
