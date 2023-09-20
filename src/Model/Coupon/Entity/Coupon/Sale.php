<?php

namespace App\Model\Coupon\Entity\Coupon;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

#[Embeddable]
class Sale
{
    const NUM = 'NUM';
    const PERCENT = 'PERCENT';

    #[Column(type: "string", length: 50)]
    private string $type;

    #[Column(type: "integer")]
    private string $value;

    public function __construct($type, $value)
    {
        Assert::greaterThan($value, 0);
        Assert::oneOf($type, [
            self::NUM,
            self::PERCENT
        ]);

        $this->type = $type;
        $this->value = $value;
    }

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
