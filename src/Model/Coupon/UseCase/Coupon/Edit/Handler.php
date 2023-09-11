<?php

declare(strict_types=1);

namespace App\Model\Coupon\UseCase\Coupon\Edit;

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
        $coupon = $this->coupons->get($command->id);

        if ($this->coupons->hasByCodeAndId($command->code, $command->id)) {
            throw new \DomainException('Coupon with this code already exists.');
        }

        $coupon->edit(
            $command->name,
            $command->code,
            new Sale(
                $command->sale->type,
                $command->sale->value
            )
        );

        $this->flusher->flush();
    }
}
