<?php

namespace App\DataFixtures;

use App\Model\Product\Entity\Tag\Id;
use App\Model\Product\Entity\Tag\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $tag = new Tag(
                Id::next(),
                $faker->text(10),
                $faker->slug(8, false)
            );
            $manager->persist($tag);
        }

        $manager->flush();
    }
}
