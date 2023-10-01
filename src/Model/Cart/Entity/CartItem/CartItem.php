<?php

declare(strict_types=1);

namespace App\Model\Cart\Entity\CartItem;

use App\Model\Cart\Entity\Cart\Cart;
use App\Model\Feature\Entity\FeatureValue\FeatureValue;
use App\Model\Product\Entity\Product\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id_value')]
    private Product $product;

    #[ORM\Column(type: "integer")]
    private $quantity;

    #[ORM\JoinTable(name: 'carts_carts_items_features_values')]
    #[ORM\JoinColumn(name: 'cart_item_id', referencedColumnName: 'id_value')]
    #[ORM\InverseJoinColumn(name: 'feature_value_id', referencedColumnName: 'id_value')]
    #[ORM\ManyToMany(targetEntity: FeatureValue::class)]
    private Collection $featuresValues;

    public function __construct(Id $id, Cart $cart, Product $product, int $quantity, $featuresValues)
    {
        Assert::greaterThanEq($quantity, 1);
        $this->id = $id;
        $this->cart = $cart;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->featuresValues = new ArrayCollection();

        if ($featuresValues) {
            foreach ($featuresValues as $featureValue) {
                $this->featuresValues->add($featureValue);
            }
        }
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getCompositeId(): string
    {
        $ids = array_map(function ($item) {
            return $item->getId();
        }, $this->featuresValues->toArray());
        sort($ids);

        return $this->product->getId() . implode('', $ids);
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function plus($quantity)
    {
        $this->quantity = $this->quantity + $quantity;
    }

    public function changeQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getFeaturesValues(): ArrayCollection|Collection
    {
        return $this->featuresValues;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }
}
