<?php

namespace App\Model\Coupon\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;

/**
 * @ORM\Entity
 * @ORM\Table("coupons")
 */
#[ORM\Entity(repositoryClass: CouponRepository::class)]
#[ORM\Table(name: 'coupons')]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[Column(type: "string")]
    private string $name;

    #[Column(type: "string", length: 50)]
    private string $code;

    #[Embedded(class: Sale::class)]
    private Sale $sale;

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
}
