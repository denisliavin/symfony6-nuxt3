<?php

namespace App\Model\Coupon\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Sale
{
    const NUM = 'N';
    const PERCENT = 'P';

    #[Column(type: "string", length: 50)]
    private string $type;

    #[Column(type: "integer")]
    private string $value;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue($value)
    {
        return $this->value = $value;
    }
}
