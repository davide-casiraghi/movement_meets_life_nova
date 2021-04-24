<?php

namespace App\Services;

use App\Http\Requests\PostCategoryStoreRequest;
use App\Models\PostCategory;
use App\Repositories\PostCategoryRepository;
use Illuminate\Support\Collection;

class PostCategoryService
{
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
     * Create a PostCategory
     *
     * @param \App\Http\Requests\PostCategoryStoreRequest $request
     *
     * @return \App\Models\PostCategory
     */
    public function createPostCategory(PostCategoryStoreRequest $request): PostCategory
    {
        $postCategory = $this->postCategoryRepository->store($request->all());

        return $postCategory;
    }

    /**
     * Update the PostCategory
     *
     * @param \App\Http\Requests\PostCategoryStoreRequest $request
     * @param int $postCategoryId
     *
     * @return \App\Models\PostCategory
     */
    public function updatePostCategory(PostCategoryStoreRequest $request, int $postCategoryId): PostCategory
    {
        $postCategory = $this->postCategoryRepository->update($request->all(), $postCategoryId);

        return $postCategory;
    }

    /**
     * Return the PostCategory from the database
     *
     * @param int $postCategoryId
     *
     * @return \App\Models\PostCategory
     */
    public function getById(int $postCategoryId): PostCategory
    {
        return $this->postCategoryRepository->getById($postCategoryId);
    }

    /**
     * Return the PostCategory id by category name
     *
     * @param  string  $postCategoryName
     *
     * @return int
     */
    public function getIdByCategoryName(string $postCategoryName): int
    {
        return $this->postCategoryRepository->getCategoryIdByName($postCategoryName);
    }

    /**
     * Get all the PostCategoriess
     *
     * @return Collection
     */
    public function getPostCategories(): Collection
    {
        return $this->postCategoryRepository->getAll();
    }

    /**
     * Delete the PostCategory from the database
     *
     * @param int $postCategoryId
     */
    public function deletePostCategory(int $postCategoryId): void
    {
        $this->postCategoryRepository->delete($postCategoryId);
    }
}
