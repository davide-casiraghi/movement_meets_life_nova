<?php


namespace App\Repositories;

use App\Models\Tag;


class TagRepository {

    /**
     * Get all Tags.
     *
     * @return iterable
     */
    public function getAll()
    {
        return Tag::all();
    }

    /**
     * Get Tag by id
     *
     * @param int $id
     * @return Tag
     */
    public function getById(int $id)
    {
        return Tag::findOrFail($id);
    }

    /**
     * Store Tag
     *
     * @param $data
     * @return Tag
     */
    public function store($data)
    {
        $tag = new Tag();
        $tag->tag = $data['tag'];

        $tag->save();

        return $tag->fresh();
    }

    /**
     * Update Tag
     *
     * @param $data
     * @param int $id
     * @return Tag
     */
    public function update($data, int $id)
    {
        $tag = $this->getById($id);
        $tag->tag = $data['tag'];

        $tag->update();

        return $tag;
    }

    /**
     * Delete Tag
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        Tag::destroy($id);
    }
}