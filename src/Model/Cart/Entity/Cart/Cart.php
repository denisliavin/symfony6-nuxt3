<?php

declare(strict_types=1);

namespace App\Model\Cart\Entity\Cart;

use App\Model\Cart\Entity\CartItem\CartItem;
use App\Model\Cart\Entity\CartOwner\CartOwner;
use App\Model\Coupon\Entity\Coupon\Coupon;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'carts_carts')]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: CartOwner::class)]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id_value')]
    private CartOwner $owner;

    #[ORM\ManyToOne(targetEntity: Coupon::class, inversedBy: 'carts')]
    #[ORM\JoinColumn(name: 'coupon_id', referencedColumnName: 'id')]
    private Coupon|null $coupon = null;

    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'cart')]
    private Collection $items;
}
