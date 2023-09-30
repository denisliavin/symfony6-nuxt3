<?php

namespace App\DataFixtures;

use App\Model\Product\Entity\Category\Category;
use App\Model\Product\Entity\Category\Id;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $category = new Category(
                Id::next(),
                $faker->slug(8, false),
                'icon',
                $faker->text(50)
            );
            $manager->persist($category);
        }

        $manager->flush();
    }
}
