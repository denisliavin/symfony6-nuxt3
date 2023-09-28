<?php

declare(strict_types=1);

namespace App\Model\Cart\Entity\Cart;

use App\Model\Cart\Entity\CartItem\Id as CartItemId;
use App\Model\Cart\Entity\CartItem\CartItem;
use App\Model\Cart\Entity\CartOwner\CartOwner;
use App\Model\Coupon\Entity\Coupon\Coupon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'carts_carts')]
class Cart
{
    #[ORM\Embedded(class: Id::class)]
    private Id $id;

    #[ORM\OneToOne(targetEntity: CartOwner::class)]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id_value')]
    private CartOwner $owner;

    #[ORM\ManyToOne(targetEntity: Coupon::class, inversedBy: 'carts')]
    #[ORM\JoinColumn(name: 'coupon_id', referencedColumnName: 'id_value')]
    private Coupon|null $coupon = null;

    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'cart')]
    private Collection $items;

    public function __construct(Id $id, CartOwner $owner, Coupon|null $coupon)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->coupon = $coupon;
        $this->items = new ArrayCollection();
    }

    public function edit( Coupon|null $coupon): void
    {
        $this->coupon = $coupon;
    }

    public function add(CartItem $item): void
    {

        foreach ($this->items as $i => $current) {
            if ($current->getCompositeId() == $item->getCompositeId()) {
                $this->items[$i] = $current->plus($item->getQuantity());
                return;
            }
        }
        $this->items->add($item);
    }

    public function set($id, $quantity): void
    {
        foreach ($this->items as $i => $current) {
            if ($current->getId() == $id) {
                $this->items[$i] = $current->changeQuantity($quantity);
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function remove(CartItemId $id): void
    {
        foreach ($this->items as $i => $current) {
            if ($current->getId() == $id) {
                $this->items->removeElement($current);
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function clear(): void
    {
        $this->items = new ArrayCollection();
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getAmount(): int
    {
        return $this->items->count();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }
}
