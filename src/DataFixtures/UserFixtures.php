<?php

namespace App\DataFixtures;

use App\Model\Product\Entity\Tag\Id;
use App\Model\Product\Entity\Tag\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

            $manager->persist($tag);


        $manager->flush();
    }
}
