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
    private Generator $fakerBe;

    public function __construct()
    {
        $this->fakerFr = Factory::create('fr_FR');
        $this->fakerEn = Factory::create('en_GB');
        $this->fakerDe = Factory::create('de_DE');
        $this->fakerBe = Factory::create('nl_NL');
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
            $country->setName($name);

            switch ($name) {
                case 'England':
                    $country
                        ->setAddress($this->fakerEn->address)
                        ->setEmail($this->fakerEn->email)
                    ;
                    break;
                case 'France':
                    $country
                        ->setAddress($this->fakerFr->address)
                        ->setEmail($this->fakerFr->email)
                    ;
                    break;
                case 'Belgium':
                    $country
                        ->setAddress($this->fakerBe->address)
                        ->setEmail($this->fakerBe->email)
                    ;
                    break;
                case 'Germany':
                    $country
                        ->setAddress($this->fakerDe->address)
                        ->setEmail($this->fakerDe->email)
                    ;
                    break;
                default:
                    $country
                        ->setAddress($this->fakerEn->address)
                        ->setEmail($this->fakerEn->email)
                    ;
            }

            $manager->persist($country);
        }

        $manager->flush();
    }
}
