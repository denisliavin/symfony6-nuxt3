<?php

declare(strict_types=1);

namespace App\Model\Cart\UseCase\Cart\Items\Add\ByClient;

use App\Model\Cart\Entity;
use App\Model\Cart\Entity\Cart\Cart;
use App\Model\Cart\Entity\Cart\CartRepository;
use App\Model\Cart\Entity\CartItem\CartItem;
use App\Model\Cart\Entity\CartOwner\CartOwner;
use App\Model\Cart\Entity\CartOwner\CartOwnerRepository;
use App\Model\Flusher;
use App\Model\Product\Entity\Product\ProductRepository;

class Handler
{
    private $products;
    private $cartsOwners;
    private $carts;
    private $flusher;

    public function __construct(
        ProductRepository $products,
        CartOwnerRepository $cartsOwners,
        CartRepository $carts,
        Flusher $flusher
    )
    {
        $this->products = $products;
        $this->cartsOwners = $cartsOwners;
        $this->carts = $carts;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $cart = $this->carts->findByIdOrKey($command->user_id, $command->key);

        if (!$cart) {
            $owner = new CartOwner(Entity\CartOwner\Id::next(), $command->key, $command->user_id);
            $cart = new Cart(Entity\Cart\Id::next(), $owner, null);

            $this->cartsOwners->add($owner);
            $this->carts->add($cart);
        }

        $product = $this->products->get($command->product_id);
        $num = 0;

        foreach ($product->getFeaturesValues() as $productFeatureValue) {
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
            $product,
            $command->quantity,
            $command->featuresValues
        );

        $cart->add($cartItem);

        $this->flusher->flush();
    }
}
