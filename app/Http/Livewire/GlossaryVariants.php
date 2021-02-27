<?php

namespace App\Http\Livewire;

use App\Models\Glossary;
use App\Models\GlossaryVariant;
use App\Repositories\GlossaryVariantRepository;
use App\Services\GlossaryService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    public $glossaryTerm;
    public $variants; //Collection
    public $newVariant;
    public $showModal = false;
    public $locales;

    protected $rules = [
        'newVariant.term' => ['required', 'string'],
    ];

    protected $listeners = ['variantsRefresh' => 'mount'];

    /**
     * The component constructor
     *
     * @param int $glossaryId
     */
    public function mount(int $glossaryId)
    {
        $glossaryService = App::make(GlossaryService::class);
        $this->glossaryTerm = $glossaryService->getById($glossaryId);

        $this->variants = $this->glossaryTerm->variants->sortBy('order');
        $this->locales = LaravelLocalization::getSupportedLocales();
    }

    /**
     * Default component render method
     */
    public function render()
    {
        return view('livewire.glossary-variants');
    }

    /**
     * Reorder variants with Drag and Drop
     *
     * @param array $orderedIds
     */
    public function reorder(array $orderedIds)
    {
        // Array with itemId as key and order as value
        $orderedIds = collect($orderedIds)->mapWithKeys(
            function ($item) {
                return [$item['value'] => $item['order']];
            }
        )->toArray();

        // Assign the order to the variants
        $this->variants = $this->variants->map(
            function ($item) use ($orderedIds) {
                $item->order = $orderedIds[$item->id];
                return $item;
            }
        )->sortBy('order');

        // Update the variants on DB
        foreach ($this->variants as $variant) {
            $variant->update();
        }
    }

    /**
     * Store a newly created variant in storage.
     */
    public function saveGlossaryVariant(): void
    {
        $glossaryVariantRepository = App::make(
            GlossaryVariantRepository::class
        );

        //$this->validate();

        $this->newVariant['glossary_id'] = $this->glossaryTerm->id;

        //dd($this->newVariant);

        $variant = $glossaryVariantRepository->store($this->newVariant);

        // Reload variants
        $this->emit('variantsRefresh', $this->glossaryTerm->id);

        $this->newVariant = [];
    }


    /**
     * Delete a variant
     *
     * @param int $variantId
     */
    public function delete(int $variantId)
    {
        $glossaryVariantRepository = App::make(
            GlossaryVariantRepository::class
        );

        /*$this->variants->reject(function ($item) use ($variantId) {
            return $item->id == $variantId;
        });*/

        $glossaryVariantRepository->delete($variantId);

        // Reload variants
        $this->emit('variantsRefresh', $this->glossaryTerm->id);
    }

    /**
     * Open the modal
     */
    public function openModal(): void
    {
        $this->showModal = true;
    }

    /**
     * Close the modal
     */
    public function closeModal(): void
    {
        $this->showModal = false;
    }



}
