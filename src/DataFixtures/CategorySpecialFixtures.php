<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorySpecialFixtures extends Fixture
{
    public const CATEGORIES = [
        'houblon',
        'rose',
        'menthe',
        'grenadine',
        'réglisse',
        'marron',
        'whisky',
        'bio',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $name) {
            $category = new Category();
            $category->setName($name);
            $category->setTerm('special');

            $manager->persist($category);
        }

        $manager->flush();
    }
}
