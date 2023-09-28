<?php

namespace App\Model\Coupon\Entity\Coupon;

use App\Model\Cart\Entity\Cart\Cart;
use App\Model\Feature\Entity\Feature\FeatureValue;
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
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Column(type: "string")]
    private string $name;

    #[Column(type: "string", length: 50)]
    private string $code;

    #[Embedded(class: Sale::class)]
    private Sale $sale;/** @var Collection<int, FeatureValue> An ArrayCollection of Bug objects. */

    #[ORM\OneToMany(targetEntity: Cart::class, mappedBy: 'coupon')]
    private Collection $carts;

    public function __construct($name, $code, Sale $sale)
    {
        Assert::notEmpty($name);
        Assert::notEmpty($code);

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

    public function getId(): ?string
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
