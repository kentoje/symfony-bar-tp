<?php

namespace App\DataFixtures;

use App\Entity\Country;

class CountryGroupFixtures {
    private array $countries;

    public function __construct()
    {
        $this->countries = [];
    }

    public function getCountries(): array
    {
        return $this->countries;
    }

    public function addCountry(?Country $country): self
    {
        $this->countries[] = $country;

        return $this;
    }
}
