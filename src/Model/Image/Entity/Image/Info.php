<?php

declare(strict_types=1);

namespace App\Model\Image\Entity\Image;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Info
{
    #[Column(type: "string")]
    private $path;

    #[Column(type: "string")]
    private $name;

    #[Column(type: "integer")]
    private $size;

    public function __construct(string $path, string $name, int $size)
    {
        $this->path = $path;
        $this->name = $name;
        $this->size = $size;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
