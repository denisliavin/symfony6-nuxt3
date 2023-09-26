<?php

declare(strict_types=1);

namespace App\Model\Cart\Entity\CartItem;

use App\Model\Cart\Entity\Cart\Cart;
use App\Model\Cart\Entity\CartOwner\Id;
use App\Model\Product\Entity\Product\Product;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;

#[ORM\Entity]
#[ORM\Table(name: 'carts_carts_items')]
class CartItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'items')]
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'cartItems')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product $product;

    #[ORM\Column(type: "integer")]
    private $quantity;

    #[Embedded(class: Features::class)]
    private Features|null $features = null;
}
