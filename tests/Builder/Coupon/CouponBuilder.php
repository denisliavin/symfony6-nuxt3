<?php

declare(strict_types=1);

namespace App\Tests\Builder\Coupon;

use App\Model\Coupon\Entity\Coupon\Id;
use App\Model\Coupon\Entity\Coupon\Coupon;
use App\Model\Coupon\Entity\Coupon\Sale;

class CouponBuilder
{
    private $name = 'Coupon name';
    private $code = 'Coupon code';
    private $type = Sale::NUM;
    private $value = 10;

    public function build(): Coupon
    {
        $coupon = new Coupon(
            Id::next(),
            $this->name,
            $this->code,
            new Sale(
                $this->type,
                $this->value
            )
        );

        return $coupon;
    }
}
