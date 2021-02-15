<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        $countries = [];

        $names = ['Belgium', 'French', 'English', 'Germany'];
        foreach ($names as $name) {
            $country = new Country();
            $country->setName($name);

            $manager->persist($country);

            $countries[] = $country;
        }

        for ($i = 0; $i < 10; $i++) {
            $beer = new Beer();
            $beer
                ->setName($this->faker->colorName . ' ' . $this->faker->firstNameFemale)
                ->setDescription($this->faker->sentence)
                ->setPublishedAt($this->faker->dateTime)
                ->setDegree($this->faker->randomFloat(
                    2,
                    3,
                    100
                ))
                ->setPrice($this->faker->randomFloat(
                    2,
                    0.99,
                    1500
                ))
                ->setCountry($countries[random_int(0, count($countries) - 1)])
            ;

            $manager->persist($beer);
        }

        $manager->flush();
    }
}
