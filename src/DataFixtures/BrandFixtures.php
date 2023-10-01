<?php

namespace App\DataFixtures;

use App\Model\Product\Entity\Brand\Id;
use App\Model\Product\Entity\Brand\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BrandFixtures extends Fixture
{
    public const BRAND_REFERENCE = 'brand_';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $brand = new Brand(
                Id::next(),
                $faker->text(10),
                $faker->slug(8, false)
            );
            $manager->persist($brand);

            $this->addReference(self::BRAND_REFERENCE . $i, $brand);
        }

        $manager->flush();
    }
}
