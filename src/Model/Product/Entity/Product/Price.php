<?php

namespace App\Model\Product\Entity\Product;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

#[Embeddable]
class Price
{
    #[Column(type: 'decimal', precision: 8, scale: 2)]
    private $new;

    #[Column(type: 'decimal', precision: 8, scale: 2)]
    private $old;

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
