<?php

namespace App\Repositories;

use App\Models\Glossary;
use App\Models\GlossaryVariant;
use Illuminate\Support\Facades\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GlossaryVariantRepository
{

    /**
     * Get Glossary variants bt Glossary term id
     *
     * @param int $id
     * @return GlossaryVariant
     */
    public function getById(int $id): GlossaryVariant
    {
        return GlossaryVariant::findOrFail($id);
    }

    /**
     * Store Glossary Variant term
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
     * Update Glossary term
     *
     * @param array $data
     * @param int $id
     * @return Glossary
     */
    /*public function update(array $data, int $id): Glossary
    {
        $glossaryVariant = $this->getById($id);
        $glossaryVariant->term = $data['term'];
        $glossaryVariant->glossary_id = $data['glossary_id'];

        $glossaryVariant->update();

        return $glossary;
    }*/

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
