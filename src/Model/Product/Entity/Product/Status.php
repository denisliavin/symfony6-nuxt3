<?php

namespace App\Model\Product\Entity\Product;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

#[Embeddable]
class Status
{
    const TYPE_ENABLED = 'ENABLED';
    const TYPE_DISABLED = 'DISABLED';

    #[Column(type: 'string', length: 50)]
    private $value;

    public function __construct($value)
    {
        Assert::oneOf($value, [
            self::TYPE_ENABLED,
            self::TYPE_DISABLED
        ]);

        $this->value = $value;
    }

    public function edit($value)
    {
        Assert::oneOf($value, [
            self::TYPE_ENABLED,
            self::TYPE_DISABLED
        ]);

        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
