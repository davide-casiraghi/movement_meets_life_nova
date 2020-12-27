<?php

namespace App\Services;

use App\Http\Requests\PostCategoryStoreRequest;
use App\Repositories\PostCategoryRepository;

class PostCategoryService {

    private PostCategoryRepository $postCategoryRepository;

    /**
     * PostCategoryService constructor.
     *
     * @param \App\Repositories\PostCategoryRepository $postCategoryRepository
     */
    public function __construct(
        PostCategoryRepository $postCategoryRepository
    ) {
        $this->postCategoryRepository = $postCategoryRepository;
    }

    /**
     * Create a gender
     *
     * @param \App\Http\Requests\PostCategoryStoreRequest $data
     *
     * @return \App\Models\PostCategory
     */
    public function createPostCategory(PostCategoryStoreRequest $data)
    {
        $postCategory = $this->postCategoryRepository->store($data);

        return $postCategory;
    }

    /**
     * Update the gender
     *
     * @param \App\Http\Requests\PostCategoryStoreRequest $data
     * @param int $postCategoryId
     *
     * @return \App\Models\PostCategory
     */
    public function updatePostCategory(PostCategoryStoreRequest $data, int $postCategoryId)
    {
        $postCategory = $this->postCategoryRepository->update($data, $postCategoryId);

        return $postCategory;
    }

    /**
     * Return the gender from the database
     *
     * @param int $postCategoryId
     *
     * @return \App\Models\PostCategory
     */
    public function getById(int $postCategoryId)
    {
        return $this->postCategoryRepository->getById($postCategoryId);
    }

    /**
     * Get all the genders
     *
     * @return iterable
     */
    public function getPostCategories()
    {
        return $this->postCategoryRepository->getAll();
    }

    /**
     * Delete the gender from the database
     *
     * @param int $postCategoryId
     */
    public function deletePostCategory(int $postCategoryId): void
    {
        $this->postCategoryRepository->delete($postCategoryId);
    }

}