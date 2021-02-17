<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class BeerFixtures extends Fixture
{
    public const MAX = 20;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::MAX; $i++) {
            $beer = new Beer();
            $beer
                ->setName(sprintf(
                    '%s %s',
                    $this->faker->colorName,
                    $this->faker->firstNameFemale,
                ))
                ->setDescription($this->faker->word)
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
            ;

            $manager->persist($beer);
            $manager->flush();
        }
    }
}
