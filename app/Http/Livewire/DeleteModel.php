<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DeleteModel extends Component
{
    public $model;
    public $modelName;
    public $showModal = false;

    public function mount($model, $modelName)
    {
        $this->model = $model;
        $this->modelName = $modelName;
    }

    public function render()
    {
        return view('livewire.delete-model');
    }

    public function delete()
    {
        $this->showModal = true;
    }

    public function confirmDelete()
    {
        $this->model->delete();
        $this->showModal = false;

        session()->flash('success', ucfirst($this->modelName) . ' deleted successfully');
        return redirect(route('posts.index'));
    }

    public function close()
    {
        $this->showModal = false;
    }
}
