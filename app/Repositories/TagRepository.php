<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Facades\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TagRepository implements TagRepositoryInterface {

    /**
     * Get all Tags.
     *
     * @return \Illuminate\Database\Eloquent\Collection
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
    public function getById(int $id): Tag
    {
        return Tag::findOrFail($id);
    }

    /**
     * Store Tag
     *
     * @param $data
     * @return Tag
     */
    public function store($data): Tag
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
    public function update($data, int $id): Tag
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