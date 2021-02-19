<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddTeacher extends Component
{
    public $teachers;
    public $selected;

    public function mount($teachers, $selected)
    {
        $this->teachers = $teachers;
        $this->selected = $selected;
    }

    public function render()
    {
        return view('livewire.add-teacher');
    }
}
