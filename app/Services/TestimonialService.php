<?php

namespace App\Services;

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
     * @param array $data
     *
     * @return \App\Models\Testimonial
     */
    public function createTestimonial(array $data): Testimonial
    {
        $testimonial = $this->testimonialRepository->store($data);

        return $testimonial;
    }

    /**
     * Update the Testimonial
     *
     * @param array $data
     * @param int $testimonialId
     *
     * @return \App\Models\Testimonial
     */
    public function updateTestimonial(array $data, int $testimonialId): Testimonial
    {
        $testimonial = $this->testimonialRepository->update($data, $testimonialId);

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
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param \App\Models\Testimonial $testimonial
     * @param \App\Http\Requests\TestimonialStoreRequest $data
     *
     * @return void
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function storeImages(Testimonial $testimonial, TestimonialStoreRequest $data): void
    {
        if ($data->file('photo')) {
            $photo = $data->file('photo');
            if ($photo->isValid()) {
                $testimonial->addMedia($photo)->toMediaCollection('testimonials');
            }
        }
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
