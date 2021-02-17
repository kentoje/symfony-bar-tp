<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class CountryFixtures extends Fixture
{

    private Generator $fakerFr;
    private Generator $fakerEn;
    private Generator $fakerDe;

    public function __construct()
    {
        $this->fakerFr = Factory::create('fr_FR');
        $this->fakerEn = Factory::create('en_GB');
        $this->fakerDe = Factory::create('de_DE');
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
                ->setEmail($this->fakerFr->email)
            ;

            switch ($name) {
                case 'England':
                    $country->setAddress($this->fakerEn->address);
                    break;
                case 'France' || 'Belgium':
                    $country->setAddress($this->fakerFr->address);
                    break;
                case 'Germany':
                    $country->setAddress($this->fakerDe->address);
                    break;
                default:
                    $country->setAddress($this->fakerEn->address);
            }

            $manager->persist($country);
        }

        $manager->flush();
    }
}
