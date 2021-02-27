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
     * @return Glossary
     */
    /*public function getById(int $glossaryTermId): Glossary
    {
        return GlossaryVariant::where($id);
    }*/




    /**
     * Store Glossary Variant term
     *
     * @param array $data
     * @return GlossaryVariant
     */
    public function store(array $data): GlossaryVariant
    {
        $glossaryVariant = new GlossaryVariant();
        $glossaryVariant->term = $data['term'];
        $glossaryVariant->glossary_id = $data['glossary_id'];

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
        $glossary = $this->getById($id);
        $glossary = self::assignDataAttributes($glossary, $data);

        $glossary->update();

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
