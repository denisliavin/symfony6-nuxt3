<?php

namespace App\DataFixtures;

use App\Model\Coupon\Entity\Coupon\Coupon;
use App\Model\Coupon\Entity\Coupon\Sale;
use App\Model\Product\Entity\Brand\Id;
use App\Model\Product\Entity\Brand\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CouponFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $coupon = new Coupon(
                \App\Model\Coupon\Entity\Coupon\Id::next(),
                $faker->text(10),
                strtolower($faker->text(5)),
                new Sale(
                    $faker->randomElement([Sale::PERCENT, Sale::NUM]),
                    $faker->numberBetween(1, 99)
                )
            );
            $manager->persist($coupon);
        }

        $manager->flush();
    }
}
