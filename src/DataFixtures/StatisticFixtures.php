<?php

namespace App\DataFixtures;

use App\Entity\Category;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

// Vos entités
use App\Entity\Client;
use App\Entity\Statistic;
use App\Entity\Beer;
use Faker\Factory;
use Faker\Generator;

class StatisticFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->faker = Factory::create('fr_FR');

    }

    public function load(ObjectManager $manager)
    {

        $clients = [];

        for ($i = 0; $i < 10; $i++) {
            $client = new Client();
            $client
                ->setEmail($this->faker->email)
                ->setName($this->faker->name)
                ->setAge(rand(18, 99))
                ->setWeight(rand(0, 100))
                ->setNumberBeer(rand(1, 200));
            $manager->persist($client);

            array_push($clients, $client);
        }
        $manager->flush();


        $repository = $this->em->getRepository(Beer::class);
        $beers = $repository->findAll();

        $repositoryCategory = $this->em->getRepository(Category::class);
        $categories = $repositoryCategory->findAll();


        for ($i = 0; $i < 20; $i++) {
            $statistic = new Statistic();
            $statistic
                ->setClientId($clients[rand(0, count($clients) - 1)])
                ->setBeerId($beers[rand(0, count($beers) - 1)])
                ->setCategoryId($categories[rand(0, count($categories) - 1)]->getId())
                ->setScore(rand(0, 20));
            $manager->persist($statistic);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            AppFixtures::class,
        );
    }
}
