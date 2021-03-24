<?php

namespace App\DataFixtures;

use App\Entity\Quote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class QuoteFixtures extends Fixture
{
    public const PRIORITY_NONE = 'none';
    public const PRIORITY_IMPORTANT = 'important';
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
                    "%s Quote %s",
                    addslashes('#'),
                    $this->faker->title,
                ))
                ->setContent(sprintf(
                    "%s%s%s",
                    addslashes('`'),
                    $this->faker->firstNameFemale,
                    addslashes('`'),
                ))
                ->setPosition($this->faker->randomElement([self::PRIORITY_IMPORTANT, self::PRIORITY_NONE]))
                ->setCreatedAt($this->faker->dateTime)
            ;

            $manager->persist($quote);
        }

        $manager->flush();
    }
}
