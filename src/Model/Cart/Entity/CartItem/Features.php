<?php

declare(strict_types=1);

namespace App\Model\Cart\Entity\CartItem;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Features
{
    #[Column(type: "string", nullable: true)]
    private $value;

    public function getSimpleValue(): string
    {
        return $this->value;
    }

    public function __construct($value)
    {
        $this->value = $value;
    }
}
