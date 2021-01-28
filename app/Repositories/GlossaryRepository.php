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
            if (!empty($searchParameters['status'])) {
                $query->currentStatus($searchParameters['status']);
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
        $glossary->term = $data['term'];
        $glossary->definition = $data['definition'];
        $glossary->body = $data['body'];

        $glossary->save();

        $glossary->setStatus('published');

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
        $glossary->term = $data['term'];
        $glossary->definition = $data['definition'];
        $glossary->body = $data['body'];

        // Translations
        foreach (LaravelLocalization::getSupportedLocales() as $countryCode => $countryAvTrans) {
            if ($countryCode != Config::get('app.fallback_locale')) {
                $glossary->setTranslation('term', $countryCode, $data['term_' . $countryCode] ?? null);
                $glossary->setTranslation('definition', $countryCode, $data['definition_' . $countryCode] ?? null);
                $glossary->setTranslation('body', $countryCode, $data['body_' . $countryCode] ?? null);
            }
        }

        $glossary->update();

        $status = (isset($data['status'])) ? 'published' : 'unpublished';
        if ($glossary->publishingStatus() != $status) {
            $glossary->setStatus($status);
        }

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
}
