<?php

declare(strict_types=1);

namespace App\Model\Cart\Entity\CartItem;

use Doctrine\ORM\Mapping\Embeddable;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[Embeddable]
class Id
{
    #[ORM\Id]
    #[ORM\Column]
    private $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    public static function next(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
