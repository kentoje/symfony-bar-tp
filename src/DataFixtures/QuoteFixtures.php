<?php

namespace App\DataFixtures;

use App\Entity\Quote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class QuoteFixtures extends Fixture
{
    public const MAX = 10;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::MAX; $i++) {
            $quote = new Quote();
            $quote
                ->setTitle(sprintf(
                    "Quote %s",
                    $this->faker->title,
                ))
                ->setContent($this->faker->sentence)
            ;

            $manager->persist($quote);
        }

        $manager->flush();
    }
}
