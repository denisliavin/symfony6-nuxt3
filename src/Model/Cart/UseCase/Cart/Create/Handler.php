<?php

declare(strict_types=1);

namespace App\Model\Cart\UseCase\Cart\Create;

use App\Model\Cart\Entity;
use App\Model\Cart\Entity\Cart\CartRepository;
use App\Model\Cart\Entity\Cart\Cart;
use App\Model\Cart\Entity\CartOwner\CartOwner;
use App\Model\Cart\Entity\CartOwner\CartOwnerRepository;
use App\Model\Flusher;

class Handler
{
    private $carts;
    private $cartsOwners;
    private $flusher;

    public function __construct(CartOwnerRepository $cartsOwners, CartRepository $carts, Flusher $flusher)
    {
        $this->cartsOwners = $cartsOwners;
        $this->carts = $carts;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $owner = new CartOwner(
            Entity\CartOwner\Id::next(),
            null,
            $command->user_id
        );

        $cart = new Cart(
            $command->cart_id,
            $owner,
            null
        );


        $this->cartsOwners->add($owner);
        $this->carts->add($cart);
        $this->flusher->flush();
    }
}
