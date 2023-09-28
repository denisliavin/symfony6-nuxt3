<?php

namespace App\Model\Coupon\Entity\Coupon;

use App\Model\Cart\Entity\Cart\Cart;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table("coupons")
 */
#[ORM\Entity]
#[ORM\Table(name: 'coupons')]
class Coupon
{
    #[ORM\Embedded(class: Id::class)]
    private Id $id;

    #[Column(type: "string")]
    private string $name;

    #[Column(type: "string", length: 50)]
    private string $code;

    #[Embedded(class: Sale::class)]
    private Sale $sale;

    #[ORM\OneToMany(targetEntity: Cart::class, mappedBy: 'coupon')]
    private Collection $carts;

    public function __construct(Id $id, $name, $code, Sale $sale)
    {
        Assert::notEmpty($name);
        Assert::notEmpty($code);

        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->sale = $sale;
    }

    public function edit($name, $code, Sale $sale)
    {
        Assert::notEmpty($name);
        Assert::notEmpty($code);

        $this->name = $name;
        $this->code = $code;
        $this->sale = $sale;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getSale(): Sale
    {
        return $this->sale;
    }

    public function __toString()
    {
        return $this->name;
    }
}
