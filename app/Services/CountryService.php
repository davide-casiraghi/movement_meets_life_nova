<?php

namespace App\Services;

use App\Http\Requests\CountryStoreRequest;
use App\Models\Country;
use App\Repositories\CountryRepository;

class CountryService
{
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
     * Create a country
     *
     * @param \App\Http\Requests\CountryStoreRequest $data
     *
     * @return \App\Models\Country
     */
    public function createCountry(CountryStoreRequest $data): Country
    {
        $country = $this->countryRepository->store($data->all());

        return $country;
    }

    /**
     * Update the country
     *
     * @param \App\Http\Requests\CountryStoreRequest $data
     * @param int $countryId
     *
     * @return \App\Models\Country
     */
    public function updateCountry(CountryStoreRequest $data, int $countryId): Country
    {
        $country = $this->countryRepository->update($data->all(), $countryId);

        return $country;
    }

    /**
     * Return the country from the database
     *
     * @param int $countryId
     *
     * @return \App\Models\Country
     */
    public function getById(int $countryId): Country
    {
        return $this->countryRepository->getById($countryId);
    }

    /**
     * Get all the countries
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCountries()
    {
        return $this->countryRepository->getAll();
    }

    /**
     * Delete the country from the database
     *
     * @param int $countryId
     */
    public function deleteCountry(int $countryId): void
    {
        $this->countryRepository->delete($countryId);
    }
}
