<?php

declare(strict_types=1);

namespace App\Model\Cart\UseCase\Cart\Items\Remove;

use App\Model\Cart\Entity\CartItem\Id;
use App\Model\Cart\Entity\Cart\CartRepository;
use App\Model\Flusher;

class Handler
{
    private $carts;
    private $flusher;

    public function __construct(CartRepository $carts, Flusher $flusher)
    {
        $this->carts = $carts;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $cart = $this->carts->get($command->cart_id);

        $cart->remove(new Id($command->id));

        $this->flusher->flush();
    }
}
