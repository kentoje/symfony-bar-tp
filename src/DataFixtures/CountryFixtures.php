<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture {
    public const COUNTRY_REFERENCE = 'country_ref';

    public function load(ObjectManager $manager): void
    {
//        $countries = [];

        $names = [
            'Belgium',
            'France',
            'England',
            'Germany',
        ];

        $countryGroup = new CountryGroupFixtures();

        foreach ($names as $name) {
            $country = new Country();
            $country->setName($name);

            $manager->persist($country);

//            $countries[] = $country;
            $countryGroup->addCountry($country);
        }

        $manager->flush();

//        $this->addReference(self::COUNTRY_REFERENCE, (object) $countries);
        $this->addReference(self::COUNTRY_REFERENCE, $countryGroup);
    }
}
