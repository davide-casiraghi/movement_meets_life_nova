<?php


namespace App\Repositories;

use App\Models\PostCategory;


class PostCategoryRepository implements PostCategoryRepositoryInterface {

    /**
     * Get all PostCategories.
     *
     * @return iterable
     */
    public function getAll()
    {
        return PostCategory::all();
    }

    /**
     * Get PostCategory by id
     *
     * @param int $id
     * @return PostCategory
     */
    public function getById(int $id)
    {
        return PostCategory::findOrFail($id);
    }

    /**
     * Store PostCategory
     *
     * @param $data
     * @return PostCategory
     */
    public function store($data)
    {
        $postCategory = new PostCategory();
        $postCategory->name = $data['name'];

        $postCategory->save();

        return $postCategory->fresh();
    }

    /**
     * Update PostCategory
     *
     * @param $data
     * @param int $id
     * @return PostCategory
     */
    public function update($data, int $id)
    {
        $postCategory = $this->getById($id);
        $postCategory->name = $data['name'];

        $postCategory->update();

        return $postCategory;
    }

    /**
     * Delete PostCategory
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        PostCategory::destroy($id);
    }
}