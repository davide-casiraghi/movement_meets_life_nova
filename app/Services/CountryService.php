<?php

namespace App\Services;

use App\Http\Requests\CountryStoreRequest;
use App\Repositories\CountryRepository;

class CountryService {

    private CountryRepository $countryRepository;

    /**
     * CountryService constructor.
     *
     * @param \App\Repositories\CountryRepository $countryRepository
     */
    public function __construct(
        CountryRepository $countryRepository
    ) {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Create a gender
     *
     * @param \App\Http\Requests\CountryStoreRequest $data
     *
     * @return \App\Models\Country
     */
    public function createCountry(CountryStoreRequest $data)
    {
        $country = $this->countryRepository->store($data);

        return $country;
    }

    /**
     * Update the gender
     *
     * @param \App\Http\Requests\CountryStoreRequest $data
     * @param int $countryId
     *
     * @return \App\Models\Country
     */
    public function updateCountry(CountryStoreRequest $data, int $countryId)
    {
        $country = $this->countryRepository->update($data, $countryId);

        return $country;
    }

    /**
     * Return the gender from the database
     *
     * @param int $countryId
     *
     * @return \App\Models\Country
     */
    public function getById(int $countryId)
    {
        return $this->countryRepository->getById($countryId);
    }

    /**
     * Get all the genders
     *
     * @return iterable
     */
    public function getCountries()
    {
        return $this->countryRepository->getAll();
    }

    /**
     * Delete the gender from the database
     *
     * @param int $countryId
     */
    public function deleteCountry(int $countryId): void
    {
        $this->countryRepository->delete($countryId);
    }

}