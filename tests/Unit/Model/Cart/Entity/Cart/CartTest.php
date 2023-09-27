<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Cart\Entity\Cart;

use App\Model\Cart\Entity as Entity;
use App\Model\Cart\Entity\Cart\Cart;
use App\Model\Cart\Entity\CartItem\CartItem;
use App\Model\Cart\Entity\CartItem\Features;
use App\Model\Cart\Entity\CartOwner\CartOwner;
use App\Tests\Builder\Cart\CartBuilder;
use App\Tests\Builder\Product\ProductBuilder;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testAdd(): void
    {
        $owner = new CartOwner(
            Entity\CartOwner\Id::next(),
            $guests_key = 'guests_key',
            null
        );

        $cart = new Cart(
            Entity\Cart\Id::next(),
            $owner,
            null
        );

        $product = (new ProductBuilder())->build();

        $cartItem = new CartItem(
            $cartItemId = Entity\CartItem\Id::next(),
            $cart,
            $product,
            1,
            new Features('')
        );

        $cart->add($cartItem);

        self::assertEquals($cart->getAmount(), 1);

        $cartItem = new CartItem(
            Entity\CartItem\Id::next(),
            $cart,
            $product,
            1,
            new Features('')
        );

        $cart->add($cartItem);

        self::assertEquals($cart->getAmount(), 1);

        $num = 0;

        foreach ($cart->getItems() as $item) {
            if ($item->getId() == $cartItemId) {
                self::assertEquals($item->getQuantity(), 2);
                $num = 1;
            }
        }

        self::assertEquals($cart->getAmount(), 1);

        $cartItem3 = new CartItem(
            Entity\CartItem\Id::next(),
            $cart,
            $product,
            1,
            new Features('Specific features')
        );

        $cart->add($cartItem3);

        self::assertEquals($cart->getAmount(), 2);
    }

    public function testSet(): void
    {
        $cart = (new CartBuilder())->build();
        $product = (new ProductBuilder())->build();
        $cartItem = new CartItem(
            $cartItemId = Entity\CartItem\Id::next(),
            $cart,
            $product,
            1,
            new Features('')
        );
        $cartItem2 = new CartItem(
            $cartItemId2 = Entity\CartItem\Id::next(),
            $cart,
            $product,
            1,
            new Features('')
        );
        $cart->add($cartItem);
        $cart->add($cartItem2);

        $cart->set($cartItemId, 2);
        $num = 0;

        foreach ($cart->getItems() as $item) {
            if ($item->getId() == $cartItemId) {
                self::assertEquals($item->getQuantity(), 2);
                $num = 1;
            }
        }

        self::assertEquals($num, 1);
    }

    public function testRemove(): void
    {
        $cart = (new CartBuilder())->build();
        $product = (new ProductBuilder())->build();
        $cartItem = new CartItem(
            $cartItemId = Entity\CartItem\Id::next(),
            $cart,
            $product,
            1,
            new Features('')
        );

        $cart->add($cartItem);

        $cart->remove($cartItemId);

        self::assertEquals($cart->getItems()->count(), 0);
    }

    public function testClear(): void
    {
        $cart = (new CartBuilder())->build();
        $product = (new ProductBuilder())->build();
        $cartItem = new CartItem(
            $cartItemId = Entity\CartItem\Id::next(),
            $cart,
            $product,
            1,
            new Features('')
        );

        $cart->add($cartItem);

        $cart->clear();

        self::assertEquals($cart->getItems()->count(), 0);
    }
}
