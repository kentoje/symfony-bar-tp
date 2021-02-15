<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public const COUNTRIES = [
        'Belgium',
        'France',
        'England',
        'Germany',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::COUNTRIES as $name) {
            $country = new Country();
            $country->setName($name);

            $manager->persist($country);
        }

        $manager->flush();
    }
}
