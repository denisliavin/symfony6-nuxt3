<?php

declare(strict_types=1);

namespace App\Model\Cart\UseCase\Cart\Items\Remove;

use App\Model\Coupon\Entity\Coupon\CouponRepository;
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

        $this->coupons->remove($coupon);

        $this->flusher->flush();
    }
}
