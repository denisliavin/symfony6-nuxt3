<?php

declare(strict_types=1);

namespace App\Tests\Builder\Cart;

use App\Model\Cart\Entity\Cart\Cart;
use App\Model\Cart\Entity\Cart\Id;

class CartBuilder
{
    private $owner;
    private $coupon;

    public function __construct($owner=null, $coupon=null)
    {
        if ($owner) {
            $this->owner = $owner;
        } else {
            $this->owner = (new CartOwnerBuilder())->build();
        }

        $this->coupon = $coupon;
    }

    public function build(): Cart
    {
        $cart = new Cart(
            Id::next(),
            $this->owner,
            $this->coupon
        );

        return $cart;
    }
}
