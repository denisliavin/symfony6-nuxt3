<?php

declare(strict_types=1);

namespace App\Model\Coupon\UseCase\Coupon\Create;

use App\Model\Coupon\Entity\Coupon\Id;
use App\Model\Coupon\Entity\Coupon\Coupon;
use App\Model\Coupon\Entity\Coupon\CouponRepository;
use App\Model\Coupon\Entity\Coupon\Sale;
use App\Model\Flusher;

class Handler
{
    private $coupons;
    private $flusher;

    public function __construct(CouponRepository $coupons, Flusher $flusher)
    {
        $this->coupons = $coupons;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if ($this->coupons->hasByCode($command->code)) {
            throw new \DomainException('Coupon with this code already exists.');
        }

        $coupon = new Coupon(
            Id::next(),
            $command->name,
            $command->code,
            new Sale(
                $command->sale->type,
                $command->sale->value
            )
        );

        $this->coupons->add($coupon);
        $this->flusher->flush();
    }
}
