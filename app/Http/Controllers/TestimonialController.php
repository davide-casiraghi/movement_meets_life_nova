<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\TestimonialSearchRequest;
use App\Http\Requests\TestimonialStoreRequest;
use App\Models\Testimonial;
use App\Services\CountryService;
use App\Services\TestimonialService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TestimonialController extends Controller
{
    use CheckPermission;

    private TestimonialService $testimonialService;
    private CountryService $countryService;

    public function __construct(
        TestimonialService $testimonialService,
        CountryService $countryService
    ) {
        $this->testimonialService = $testimonialService;
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\TestimonialSearchRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(TestimonialSearchRequest $request): View
    {
        $this->checkPermission('testimonials.view');

        $searchParameters = Helper::getSearchParameters($request, Testimonial::SEARCH_PARAMETERS);

        $testimonials = $this->testimonialService->getTestimonials(20, $searchParameters);
        $statuses = Testimonial::PUBLISHING_STATUS;
        $countries = $this->countryService->getCountries();

        return view('testimonials.index', [
            'testimonials' => $testimonials,
            'searchParameters' => $searchParameters,
            'statuses' => $statuses,
            'countries' => $countries,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(): View
    {
        // No permission since has to be possible for a guest use to create a testimonial

        $countries = $this->countryService->getCountries();

        return view('testimonials.create', [
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TestimonialStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TestimonialStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('testimonials.create');

        $testimonial = $this->testimonialService->createTestimonial($request);

        $message = Auth::guest() ? 'Thanks for your testimony!' : 'Testimonial created successfully';

        if (Auth::guest()) {
            return redirect()->route('testimonials.create')->with('success', $message);
        } else {
            return redirect()->route('testimonials.index')->with('success', $message);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $testimonialId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(int $testimonialId)
    {
        $this->checkPermission('testimonials.edit');

        $testimonial = $this->testimonialService->getById($testimonialId);
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();
        $countries = $this->countryService->getCountries();

        return view('testimonials.edit', [
            'testimonial' => $testimonial,
            'countriesAvailableForTranslations' => $countriesAvailableForTranslations,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\TestimonialStoreRequest $request
     * @param int $testimonialId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TestimonialStoreRequest $request, int $testimonialId): RedirectResponse
    {
        $this->checkPermission('testimonials.edit');

        $testimonial = $this->testimonialService->updateTestimonial($request, $testimonialId);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $testimonialId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $testimonialId): RedirectResponse
    {
        $this->checkPermission('testimonials.delete');

        $this->testimonialService->deleteTestimonial($testimonialId);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial deleted successfully');
    }
}
