<?php


namespace App\Services;


use App\Http\Requests\TestimonialStoreRequest;

class TestimonialServices {
    /**
     * Create an alert
     *
     * @param \App\Http\Requests\TestimonialStoreRequest $data
     *
     * @return \App\Alert
     */
    public function createAlert(TestimonialStoreRequest $data)
    {
        $testimonial = $this->testimonialRepository->store($data);

        $this->storeImages(TestimonialStoreRequest, $data);

        return TestimonialStoreRequest;
    }
}