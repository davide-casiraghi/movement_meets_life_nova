<?php


namespace App\Repositories;


use App\Models\GlossaryVariant;
use Illuminate\Support\Collection;

interface GlossaryVariantRepositoryInterface
{
    /**
     * Get Glossary variants bt Glossary term id
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get Glossary variants bt Glossary term id
     *
     * @param  int  $id
     * @return GlossaryVariant
     */
    public function getById(int $id): GlossaryVariant;

    /**
     * Store Glossary Variant (all the languages)
     *
     * @param  array  $data
     * @return GlossaryVariant
     */
    public function store(array $data): GlossaryVariant;

    /**
     * Update Glossary Variant (all the languages)
     *
     * @param  array  $data
     * @param  int  $id
     * @return GlossaryVariant
     */
    public function update(array $data, int $id): GlossaryVariant;

    /**
     * Delete Glossary Variant term
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}
