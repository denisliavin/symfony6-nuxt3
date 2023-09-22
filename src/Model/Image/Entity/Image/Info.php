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

    public function __construct(string $path, string $name)
    {
        $this->path = $path;
        $this->name = $name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
