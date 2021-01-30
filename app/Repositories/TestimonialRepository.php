<?php

namespace App\Repositories;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    /**
     * Get all Testimonials.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Testimonial::orderBy('created_at', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['name'])) {
                $query->where(
                    'name',
                    'like',
                    '%' . $searchParameters['name'] . '%'
                );
            }
            if (!empty($searchParameters['surname'])) {
                $query->where(
                    'surname',
                    'like',
                    '%' . $searchParameters['surname'] . '%'
                );
            }
            if (!empty($searchParameters['countryId'])) {
                $query->where('country_id', $searchParameters['countryId']);
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
     * Get Testimonial by id
     *
     * @param $testimonialId
     * @return Testimonial
     */
    public function getById($testimonialId): Testimonial
    {
        return Testimonial::findOrFail($testimonialId);
    }

    /**
     * Store Testimonial
     *
     * @param $data
     * @return Testimonial
     */
    public function store(array $data): Testimonial
    {
        $testimonial = new Testimonial();
        $testimonial = self::assignDataAttributes($testimonial, $data);

        $testimonial->save();

        // When created by a guest from frontend set to unpublished
        $status = Auth::guest() ? 'unpublished' : 'published';
        $testimonial->setStatus($status);

        return $testimonial->fresh();
    }

    /**
     * Update Testimonial
     *
     * @param array $data
     * @param int $id
     * @return Testimonial
     */
    public function update(array $data, int $id): Testimonial
    {
        $testimonial = $this->getById($id);
        $testimonial = self::assignDataAttributes($testimonial, $data);

        $testimonial->update();

        $status = (isset($data['status'])) ? 'published' : 'unpublished';
        if ($testimonial->publishingStatus() != $status) {
            $testimonial->setStatus($status);
        }

        return $testimonial;
    }

    /**
     * Delete Testimonial
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Testimonial::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Testimonial $testimonial
     * @param array $data
     *
     * @return \App\Models\Testimonial
     */
    public function assignDataAttributes(Testimonial $testimonial, array $data): Testimonial
    {
        $testimonial->feedback = $data['feedback'] ?? null;
        $testimonial->name = $data['name'] ?? null;
        $testimonial->surname = $data['surname'] ?? null;
        $testimonial->profession = $data['profession'] ?? null;
        $testimonial->country_id = $data['country_id'] ?? null;

        $testimonial->publish_agreement =  isset($data['publish_agreement']) ? 1 : 0;
        $testimonial->personal_data_agreement =  isset($data['personal_data_agreement']) ? 1 : 0;

        //$testimonial->publish_agreement =  ($data['publish_agreement'] == 'on') ? 1 : 0;
        //$testimonial->personal_data_agreement =  ($data['personal_data_agreement'] == 'on') ? 1 : 0;

        // Translations
        foreach (LaravelLocalization::getSupportedLocales() as $countryCode => $countryAvTrans) {
            if ($countryCode != Config::get('app.fallback_locale')) {
                $testimonial->setTranslation('feedback', $countryCode, $data['feedback_' . $countryCode] ?? null);
                $testimonial->setTranslation('profession', $countryCode, $data['profession_' . $countryCode] ?? null);
            }
        }

        return $testimonial;
    }
}
