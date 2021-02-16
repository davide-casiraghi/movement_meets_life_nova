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
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage);
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
        $insight->setStatus('published');

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

        // Translations
        foreach (LaravelLocalization::getSupportedLocales() as $countryCode => $countryAvTrans) {
            if ($countryCode != Config::get('app.fallback_locale')) {
                $insight->setTranslation('title', $countryCode, $data['title_' . $countryCode] ?? null);
                $insight->setTranslation('body', $countryCode, $data['body_' . $countryCode] ?? null);
            }
        }

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
