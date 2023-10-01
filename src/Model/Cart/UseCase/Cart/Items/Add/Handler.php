<?php

declare(strict_types=1);

namespace App\Model\Cart\UseCase\Cart\Items\Add;

use App\Model\Cart\Entity;
use App\Model\Cart\Entity\Cart\CartRepository;
use App\Model\Cart\Entity\CartItem\CartItem;
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
        $num = 0;

        foreach ($command->product->getFeaturesValues() as $productFeatureValue) {
            foreach ($command->featuresValues as $featureValue) {
                if ($featureValue->getId()->getValue() == $productFeatureValue->getId()->getValue()) {
                    $num++;
                }
            }
        }

        if ($num != count($command->featuresValues)) {
            throw new \DomainException('Feature Value no related for product');
        }

        $cartItem = new CartItem(
            Entity\CartItem\Id::next(),
            $cart,
            $command->product,
            1,
            $command->featuresValues
        );

        $cart->add($cartItem);

        $this->flusher->flush();
    }
}
