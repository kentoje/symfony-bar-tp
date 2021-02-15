<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryNormalFixtures extends Fixture
{
    public const CATEGORIES = [
        'blonde',
        'brune',
        'blanche',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $name) {
            $category = new Category();
            $category->setName($name);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
