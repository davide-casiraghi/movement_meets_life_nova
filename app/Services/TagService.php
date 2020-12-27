<?php

namespace App\Services;

use App\Http\Requests\TagStoreRequest;
use App\Repositories\TagRepository;

class TagService {

    private TagRepository $tagRepository;

    /**
     * TagService constructor.
     *
     * @param \App\Repositories\TagRepository $tagRepository
     */
    public function __construct(
        TagRepository $tagRepository
    ) {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Create a gender
     *
     * @param \App\Http\Requests\TagStoreRequest $data
     *
     * @return \App\Models\Tag
     */
    public function createTag(TagStoreRequest $data)
    {
        $tag = $this->tagRepository->store($data);

        return $tag;
    }

    /**
     * Update the gender
     *
     * @param \App\Http\Requests\TagStoreRequest $data
     * @param int $tagId
     *
     * @return \App\Models\Tag
     */
    public function updateTag(TagStoreRequest $data, int $tagId)
    {
        $tag = $this->tagRepository->update($data, $tagId);

        return $tag;
    }

    /**
     * Return the gender from the database
     *
     * @param int $tagId
     *
     * @return \App\Models\Tag
     */
    public function getById(int $tagId)
    {
        return $this->tagRepository->getById($tagId);
    }

    /**
     * Get all the genders
     *
     * @return iterable
     */
    public function getTags()
    {
        return $this->tagRepository->getAll();
    }

    /**
     * Delete the gender from the database
     *
     * @param int $tagId
     */
    public function deleteTag(int $tagId): void
    {
        $this->tagRepository->delete($tagId);
    }

}