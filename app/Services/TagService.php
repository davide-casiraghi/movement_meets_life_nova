<?php

namespace App\Services;

use App\Http\Requests\TagSearchRequest;
use App\Http\Requests\TagStoreRequest;
use App\Models\Tag;
use App\Repositories\TagRepository;

class TagService
{
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
     * Create a tag
     *
     * @param \App\Http\Requests\TagStoreRequest $request
     *
     * @return \App\Models\Tag
     */
    public function createTag(TagStoreRequest $request): Tag
    {
        $tag = $this->tagRepository->store($request->all());

        return $tag;
    }

    /**
     * Update the tag
     *
     * @param \App\Http\Requests\TagStoreRequest $request
     * @param int $tagId
     *
     * @return \App\Models\Tag
     */
    public function updateTag(TagStoreRequest $request, int $tagId): Tag
    {
        $tag = $this->tagRepository->update($request->all(), $tagId);

        return $tag;
    }

    /**
     * Return the tag from the database
     *
     * @param int $tagId
     *
     * @return \App\Models\Tag
     */
    public function getById(int $tagId): Tag
    {
        return $this->tagRepository->getById($tagId);
    }

    /**
     * Get all the tags
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getTags(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->tagRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the tag from the database
     *
     * @param int $tagId
     */
    public function deleteTag(int $tagId): void
    {
        $this->tagRepository->delete($tagId);
    }

}
