<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ClientFixtures extends Fixture
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
            $client = new Client();
            $client
                ->setEmail($this->faker->email)
                ->setName($this->faker->name)
                ->setAge(random_int(18, 95))
                ->setWeight(random_int(38, 100))
                ->setNumberBeer(random_int(1, 200))
            ;

            $manager->persist($client);
        }

        $manager->flush();
    }
}
