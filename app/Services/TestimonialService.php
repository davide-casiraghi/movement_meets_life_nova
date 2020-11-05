<?php

namespace App\Services;

use App\Http\Requests\TestimonialStoreRequest;
use App\Models\Testimonial;
use App\Repositories\TestimonialRepository;

class TestimonialService {

    private $testimonialRepository;

    public function __construct(TestimonialRepository $testimonialRepository) {
        $this->testimonialRepository = $testimonialRepository;
    }

    /**
     * Create an alert
     *
     * @param \App\Http\Requests\TestimonialStoreRequest $data
     *
     * @return \App\Models\Testimonial
     */
    public function createTestimonial(TestimonialStoreRequest $data)
    {
        $testimonial = $this->testimonialRepository->store($data);

        $this->storeImages($testimonial, $data);

        return $testimonial;
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
    private function storeImages(Testimonial $testimonial, TestimonialStoreRequest $data):void {
        if($data->file('photo')) {
            foreach ($data->file('photo') as $photo) {
                if ($photo->isValid()) {
                    $testimonial->addMedia($photo)->toMediaCollection('testimonials');
                }
            }
        }
    }
}