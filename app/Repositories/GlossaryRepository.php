<?php

namespace App\Repositories;

use App\Models\Glossary;
use Illuminate\Support\Facades\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GlossaryRepository implements GlossaryRepositoryInterface
{

    /**
     * Get all Glossary terms.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Glossary::orderBy('created_at', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['term'])) {
                $query->where(
                    'term',
                    'like',
                    '%' . $searchParameters['term'] . '%'
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

    /**
     * Get Glossary term by id
     *
     * @param int $id
     * @return Glossary
     */
    public function getById(int $id): Glossary
    {
        return Glossary::findOrFail($id);
    }

    /**
     * Store Glossary term
     *
     * @param array $data
     * @return Glossary
     */
    public function store(array $data): Glossary
    {
        $glossary = new Glossary();
        $glossary = self::assignDataAttributes($glossary, $data);

        $glossary->save();

        return $glossary->fresh();
    }

    /**
     * Update Glossary term
     *
     * @param array $data
     * @param int $id
     * @return Glossary
     */
    public function update(array $data, int $id): Glossary
    {
        $glossary = $this->getById($id);
        $glossary = self::assignDataAttributes($glossary, $data);

        $glossary->update();

        return $glossary;
    }

    /**
     * Delete Glossary term
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Glossary::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Glossary $glossary
     * @param array $data
     *
     * @return \App\Models\Glossary
     */
    public function assignDataAttributes(Glossary $glossary, array $data): Glossary
    {
        $glossary->term = $data['term'];
        $glossary->definition = $data['definition'];
        $glossary->body = $data['body'];
        $glossary->is_published = (isset($data['is_published'])) ? 1 : 0;

        // Translations
        foreach (LaravelLocalization::getSupportedLocales() as $countryCode => $countryAvTrans) {
            if ($countryCode != Config::get('app.fallback_locale')) {
                $glossary->setTranslation('term', $countryCode, $data['term_' . $countryCode] ?? null);
                $glossary->setTranslation('definition', $countryCode, $data['definition_' . $countryCode] ?? null);
                $glossary->setTranslation('body', $countryCode, $data['body_' . $countryCode] ?? null);
            }
        }

        return $glossary;
    }
}
