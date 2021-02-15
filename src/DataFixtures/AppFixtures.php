<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use App\Entity\Category;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $countries = $manager->getRepository(Country::class)->findAll();
        $normalCategories = $manager->getRepository(Category::class)->findAllNormal();
        $specialsCategories = $manager->getRepository(Category::class)->findAllSpecial();
        $beers = $manager->getRepository(Beer::class)->findAll();

        foreach ($beers as $i => $beer) {
            $randomNumber = random_int(1, count($specialsCategories));
            $specialsCategoriesCopy = [...$specialsCategories];

            $beer->addCategory($normalCategories[random_int(0, count($normalCategories) - 1)]);

            for ($j = $randomNumber; $j > 0; $j--) {
                $randomIndex = random_int(0, count($specialsCategoriesCopy) - 1);

                $beer->addCategory($specialsCategoriesCopy[$randomIndex]);

                array_splice($specialsCategoriesCopy, $randomIndex, 1);
            }

            switch($i) {
                case 0:
                    $beer->setCountry($countries[0]);
                    break;
                case 1:
                    $beer->setCountry($countries[1]);
                    break;
                case 2:
                    $beer->setCountry($countries[2]);
                    break;
                case 3:
                    $beer->setCountry($countries[3]);
                    break;
                default:
                    $beer->setCountry($countries[random_int(0, count($countries) - 1)]);
            }

            $manager->persist($beer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CountryFixtures::class,
            CategoryNormalFixtures::class,
            CategorySpecialFixtures::class,
            BeerFixtures::class,
        ];
    }
}
