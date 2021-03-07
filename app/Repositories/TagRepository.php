<?php

namespace App\Repositories;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TagRepository implements TagRepositoryInterface
{

    /**
     * Get all Tags.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Tag::orderBy('tag', 'asc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['tag'])) {
                $query->where(
                    'tag',
                    'like',
                    '%' . $searchParameters['tag'] . '%'
                );
            }
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage);
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get Tag by id
     *
     * @param int $id
     * @return Tag
     */
    public function getById(int $id): Tag
    {
        return Tag::findOrFail($id);
    }

    /**
     * Get Tag by slug
     *
     * @param string $tagSlug
     *
     * @return Tag
     */
    public function getBySlug(string $tagSlug): Tag
    {
        return Tag::where('slug', $tagSlug)->first();
    }

    /**
     * Store Tag
     *
     * @param array $data
     * @return Tag
     */
    public function store(array $data): Tag
    {
        $tag = new Tag();
        $tag->tag = $data['tag'];

        $tag->save();

        return $tag->fresh();
    }

    /**
     * Update Tag
     *
     * @param array $data
     * @param int $id
     * @return Tag
     */
    public function update(array $data, int $id): Tag
    {
        $tag = $this->getById($id);
        $tag->tag = $data['tag'];

        // Translations
        foreach (LaravelLocalization::getSupportedLocales() as $countryCode => $countryAvTrans) {
            if ($countryCode != Config::get('app.fallback_locale')) {
                $tag->setTranslation('tag', $countryCode, $data['tag_' . $countryCode] ?? null);
            }
        }

        $tag->update();

        return $tag;
    }

    /**
     * Delete Tag
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Tag::destroy($id);
    }
}
