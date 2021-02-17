<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class CountryFixtures extends Fixture
{

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

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
            $country
                ->setName($name)
                ->setAddress($this->faker->address)
                ->setEmail($this->faker->email)
            ;

            $manager->persist($country);
        }

        $manager->flush();
    }
}
