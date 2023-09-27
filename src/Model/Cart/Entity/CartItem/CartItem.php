<?php

declare(strict_types=1);

namespace App\Model\Cart\Entity\CartItem;

use App\Model\Cart\Entity\Cart\Cart;
use App\Model\Product\Entity\Product\Product;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'carts_carts_items')]
class CartItem
{
    #[ORM\Embedded(class: Id::class)]
    private Id $id;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'items')]
    #[ORM\JoinColumn(name: 'cart_id', referencedColumnName: 'id_value')]
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'cartItems')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product $product;

    #[ORM\Column(type: "integer")]
    private $quantity;

    #[Embedded(class: Features::class)]
    private Features $features;

    public function __construct(Id $id, Cart $cart, Product $product, int $quantity, Features $features)
    {
        Assert::greaterThanEq($quantity, 1);
        $this->id = $id;
        $this->cart = $cart;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->features = $features;
    }

    public function getId(): string
    {
        return $this->id->getValue();
    }

    public function getCompositeId(): string
    {
        return $this->product->getId() . $this->features->getSimpleValue();
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function plus($quantity)
    {
        return new static($this->id, $this->cart, $this->product, $this->quantity + $quantity, $this->features);
    }

    public function changeQuantity($quantity)
    {
        return new static($this->id, $this->cart, $this->product, $quantity, $this->features);
    }
}
