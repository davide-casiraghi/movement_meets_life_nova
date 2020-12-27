<?php

namespace App\Repositories;

use App\Models\Glossary;

class GlossaryRepository implements GlossaryRepositoryInterface {

    /**
     * Get all Glossary terms.
     *
     * @return iterable
     */
    public function getAll()
    {
        return Glossary::all();
    }

    /**
     * Get Glossary term by id
     *
     * @param int $id
     * @return Glossary
     */
    public function getById(int $id)
    {
        return Glossary::findOrFail($id);
    }

    /**
     * Store Glossary term
     *
     * @param $data
     * @return Glossary
     */
    public function store($data)
    {
        $glossary = new Glossary();
        $glossary->term = $data['term'];
        $glossary->definition = $data['definition'];
        $glossary->body = $data['body'];

        $glossary->save();

        return $glossary->fresh();
    }

    /**
     * Update Glossary term
     *
     * @param $data
     * @param int $id
     * @return Glossary
     */
    public function update($data, int $id)
    {
        $glossary = $this->getById($id);
        $glossary->term = $data['term'];
        $glossary->definition = $data['definition'];
        $glossary->body = $data['body'];

        $glossary->update();

        return $glossary;
    }

    /**
     * Delete Glossary term
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        Glossary::destroy($id);
    }
}