<?php

namespace App\DataFixtures;

use App\Model\Product\Entity\Product\Info;
use App\Model\Product\Entity\Product\Price;
use App\Model\Product\Entity\Product\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $priceOld = $faker->numberBetween(100, 1000);

            $product = new Product(
                \App\Model\Product\Entity\Product\Id::next(),
                $faker->slug(3, false),
                $this->getReference(CategoryFixtures::CATEGORY_REFERENCE . $faker->numberBetween(0, 9)),
                $this->getReference(BrandFixtures::BRAND_REFERENCE . $faker->numberBetween(0, 19)),
                $this->getReference(TagFixtures::TAG_REFERENCE . $faker->numberBetween(0, 19)),
                new Price(
                    round($priceOld * $faker->numberBetween(60, 100) / 100),
                    $priceOld
                ),
                new Info(
                    $faker->text(10),
                    $faker->text(100),
                    $faker->text(100)
                )
            );

            $indexFeature = $faker->numberBetween(0, 3);
            $indexValue = $faker->numberBetween(0, 3);

            $feature = $this->getReference(FeatureFixtures::FEATURE_REFERENCE . $indexFeature);
            $product->addFeatureValue($feature->getValues()->toArray()[$indexValue]);
            $product->addFeatureValue($feature->getValues()->toArray()[$indexValue + 1]);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FeatureFixtures::class,
            TagFixtures::class,
            CategoryFixtures::class,
            BrandFixtures::class
        ];
    }
}
