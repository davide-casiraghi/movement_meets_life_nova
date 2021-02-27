<?php

namespace App\Http\Livewire;

use Livewire\Component;

/**
 * Class GlossaryVariants
 *
 * Inspired by this talk of Caleb
 * https://laravel-livewire.com/screencasts/s8-dragging-list
 *
 * @package App\Http\Livewire
 * */

class GlossaryVariants extends Component
{
    public $variants = [
        ['id' => 1, 'title' => 'Do dishes'],
        ['id' => 2, 'title' => 'Dust shelves'],
        ['id' => 3, 'title' => 'Clean Counters'],
        ['id' => 4, 'title' => 'Fold Laundry'],
        ['id' => 5, 'title' => 'Scrub Toilet'],
    ];
    public function render()
    {
        return view('livewire.glossary-variants');
    }

    public function reorder($orderedIds)
    {
        //27.22
        $this->variants = collect($orderedIds)->map(function ($id) {
            return collect($this->variants)->where('id', (int) $id['value'])->first();
        })->toArray();
    }
}
