<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Coupon\Entity\Coupon;

use App\Model\Coupon\Entity\Coupon\Sale;
use App\Tests\Builder\User\CouponBuilder;
use PHPUnit\Framework\TestCase;

class EditTest extends TestCase
{
    public function testSuccess(): void
    {
        $coupon = (new CouponBuilder())->build();
        $coupon->edit(
            $name = 'name',
            $code = 'code',
            new Sale(
                $type = Sale::NUM,
                $value = 10
            )
        );

        self::assertEquals($name, $coupon->getName());
        self::assertEquals($code, $coupon->getCode());
        self::assertEquals($type, $coupon->getSale()->getType());
        self::assertEquals($value, $coupon->getSale()->getValue());
    }
}
