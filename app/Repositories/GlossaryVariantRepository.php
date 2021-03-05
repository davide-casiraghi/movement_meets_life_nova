<?php

namespace App\Repositories;

use App\Models\GlossaryVariant;
use Illuminate\Support\Collection;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class GlossaryVariantRepository implements GlossaryVariantRepositoryInterface
{

    /**
     * Get Glossary variants bt Glossary term id
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return GlossaryVariant::with('glossary')
            ->whereHas('glossary', function ($q) {
                $q->where('is_published', 1);
            })->get();


        //return GlossaryVariant::where($id);
    }

    /**
     * Get Glossary variants bt Glossary term id
     *
     * @param  int  $id
     * @return GlossaryVariant
     */
    public function getById(int $id): GlossaryVariant
    {
        return GlossaryVariant::findOrFail($id);
    }

    /**
     * Store Glossary Variant (all the languages)
     *
     * @param array $data
     * @return GlossaryVariant
     */
    public function store(array $data): GlossaryVariant
    {
        $glossaryVariant = new GlossaryVariant();

        $glossaryVariant->glossary_id = $data['glossary_id'];
        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $glossaryVariant->setTranslation('term', $key, $data['lang'][$key]);
        }

        $glossaryVariant->save();
        return $glossaryVariant->fresh();
    }

    /**
     * Update Glossary Variant (all the languages)
     *
     * @param array $data
     * @param int $id
     *
     * @return \App\Models\GlossaryVariant
     */
    public function update(array $data, int $id): GlossaryVariant
    {
        $glossaryVariant = $this->getById($id);

        $glossaryVariant->glossary_id = $data['glossary_id'];
        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $glossaryVariant->setTranslation('term', $key, $data['lang'][$key]);
        }

        $glossaryVariant->update();

        return $glossaryVariant;
    }

    /**
     * Delete Glossary Variant term
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        GlossaryVariant::destroy($id);
    }


}
