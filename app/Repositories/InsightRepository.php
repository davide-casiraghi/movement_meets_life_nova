<?php

namespace App\Repositories;

use App\Models\Insight;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class InsightRepository implements InsightRepositoryInterface
{
    public function getAll(
        int $recordsPerPage = null,
        array $searchParameters = null
    ) {
        $query = Insight::orderBy('created_at', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['title'])) {
                $query->where(
                    'title',
                    'like',
                    '%' . $searchParameters['title'] . '%'
                );
            }
            if (!is_null($searchParameters['is_published'])) {
                $query->where('is_published', $searchParameters['is_published']);
            }
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage)->withQueryString();
        } else {
            $results = $query->get();
        }

        return $results;
    }

    public function getById($insightId)
    {
        return Insight::findOrFail($insightId);
    }

    public function store(array $data)
    {
        $insight = new Insight();
        $insight = self::assignDataAttributes($insight, $data);

        $insight->save();

        $insight->tags()->sync($data['tag_ids'] ?? null);

        return $insight->fresh();
    }

    public function update(array $data, int $id)
    {
        $insight = $this->getById($id);
        $insight = self::assignDataAttributes($insight, $data);

        $insight->update();

        return $insight;
    }

    public function delete(int $id)
    {
        Insight::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Insight $insight
     * @param array $data
     *
     * @return \App\Models\Insight
     */
    public function assignDataAttributes(Insight $insight, array $data): Insight
    {
        $insight->title = $data['title'] ?? null;
        $insight->body = $data['body'] ?? null;
        $insight->is_published = (isset($data['is_published'])) ? 1 : 0;

        if (isset($data['created_at'])) {
            $insight->created_at = Carbon::createFromFormat('d/m/Y', $data['created_at']);
        }

        $insight->facebook_body = $data['facebook_body'] ?? null;
        $insight->twitter_body = $data['twitter_body'] ?? null;
        $insight->instagram_body = $data['instagram_body'] ?? null;

        $insight->published_on_facebook_on = $data['published_on_facebook_on'] ?? null;
        $insight->published_on_twitter_on = $data['published_on_twitter_on'] ?? null;
        $insight->published_on_instagram_on = $data['published_on_instagram_on'] ?? null;

        $insight->facebook_url = $data['facebook_url'] ?? null;
        $insight->twitter_url = $data['twitter_url'] ?? null;
        $insight->instagram_url = $data['instagram_url'] ?? null;

        return $insight;
    }

    /**
     * Get the last 5 Insights.
     *
     * @param int $numberOfInsights
     *
     * @return Collection
     */
    public function getLatest(int $numberOfInsights): Collection
    {
        return Insight::orderBy('created_at', 'desc')->take($numberOfInsights)->get();
    }

}
