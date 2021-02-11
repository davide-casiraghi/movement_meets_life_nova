<?php

namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\TestimonialSearchRequest;
use App\Http\Requests\TestimonialStoreRequest;
use App\Models\Testimonial;
use App\Repositories\TestimonialRepository;

class TestimonialService
{
    private TestimonialRepository $testimonialRepository;

    /**
     * TestimonialService constructor.
     *
     * @param \App\Repositories\TestimonialRepository $testimonialRepository
     */
    public function __construct(TestimonialRepository $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }

    /**
     * Return the testimonial from the database
     *
     * @param $testimonialId
     *
     * @return \App\Models\Testimonial
     */
    public function getById(int $testimonialId): Testimonial
    {
        return $this->testimonialRepository->getById($testimonialId);
    }

    /**
     * Get all the Testimonials.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getTestimonials(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->testimonialRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Create a Testimonial
     *
     * @param \App\Http\Requests\TestimonialStoreRequest $request
     *
     * @return \App\Models\Testimonial
     */
    public function createTestimonial(TestimonialStoreRequest $request): Testimonial
    {
        $testimonial = $this->testimonialRepository->store($request->all());

        ImageHelpers::storeImages($testimonial, $request, 'photo');

        return $testimonial;
    }

    /**
     * Update the Testimonial
     *
     * @param \App\Http\Requests\TestimonialStoreRequest $request
     * @param int $testimonialId
     *
     * @return \App\Models\Testimonial
     */
    public function updateTestimonial(TestimonialStoreRequest $request, int $testimonialId): Testimonial
    {
        $testimonial = $this->testimonialRepository->update($request->all(), $testimonialId);

        ImageHelpers::storeImages($testimonial, $request, 'photo');
        ImageHelpers::deleteImages($testimonial, $request, 'photo');

        return $testimonial;
    }

    /**
     * Delete the Testimonial from the database
     *
     * @param int $testimonialId
     */
    public function deleteTestimonial(int $testimonialId): void
    {
        $this->testimonialRepository->delete($testimonialId);
    }

    /**
     * Get the testimonial search parameters
     *
     * @param \App\Http\Requests\TestimonialSearchRequest $request
     *
     * @return array
     */
    public function getSearchParameters(TestimonialSearchRequest $request): array
    {
        $searchParameters = [];
        $searchParameters['name'] = $request->title ?? null;
        $searchParameters['surname'] = $request->categoryId ?? null;
        $searchParameters['countryId'] = $request->startDate ?? null;
        $searchParameters['status'] = $request->status ?? null;

        return $searchParameters;
    }
}
