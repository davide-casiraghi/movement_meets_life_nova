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
     * @param \App\Http\Requests\TagStoreRequest $data
     *
     * @return \App\Models\Tag
     */
    public function createTag(TagStoreRequest $data): Tag
    {
        $tag = $this->tagRepository->store($data);

        return $tag;
    }

    /**
     * Update the tag
     *
     * @param \App\Http\Requests\TagStoreRequest $data
     * @param int $tagId
     *
     * @return \App\Models\Tag
     */
    public function updateTag(TagStoreRequest $data, int $tagId): Tag
    {
        $tag = $this->tagRepository->update($data, $tagId);

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

    /**
     * Get the post search parameters
     *
     * @param \App\Http\Requests\TagSearchRequest $request
     *
     * @return array
     */
    public function getSearchParameters(TagSearchRequest $request): array
    {
        $searchParameters = [];
        $searchParameters['tag'] = $request->tag ?? null;

        return $searchParameters;
    }
}
