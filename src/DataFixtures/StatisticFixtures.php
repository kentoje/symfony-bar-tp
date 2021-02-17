<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use App\Entity\Category;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Statistic;

class StatisticFixtures extends Fixture
{
    public const MAX = 20;

    public function load(ObjectManager $manager): void
    {
        $beer = $manager->getRepository(Beer::class)->findFirstOne();
        $client = $manager->getRepository(Client::class)->findFirstOne();
        $category = $manager->getRepository(Category::class)->findFirstOne();

        for ($i = 0; $i < self::MAX; $i++) {
            $statistic = new Statistic();
            $statistic
                ->setScore(random_int(0, 20))
                ->setClientId($client)
                ->setBeerId($beer)
                ->setCategoryId($category->getId())
            ;

            $manager->persist($statistic);
        }

        $manager->flush();
    }
}
