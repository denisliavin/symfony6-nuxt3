<?php

namespace App\DataFixtures;

use App\Model\Feature\Entity\Feature\Feature;
use App\Model\Product\Entity\Brand\Id;
use App\Model\Product\Entity\Brand\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FeatureFixtures extends Fixture
{
    public const FEATURE_REFERENCE = 'feature_';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $feature = new Feature(
                \App\Model\Feature\Entity\Feature\Id::next(),
                $faker->text(10),
                $faker->text(100)
            );

            for ($j = 0; $j < 5; $j++) {
                $feature->attachValue($faker->text(10));
            }

            $manager->persist($feature);

            $this->addReference(self::FEATURE_REFERENCE . $i, $feature);
        }

        $manager->flush();
    }
}
