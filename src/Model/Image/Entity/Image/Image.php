<?php

declare(strict_types=1);

namespace App\Model\Image\Entity\Image;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;

#[ORM\Entity]
#[ORM\Table(name: 'images')]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeImmutable $date;

    #[Embedded(class: Info::class)]
    private Info $info;

    public function __construct(\DateTimeImmutable $date, Info $info)
    {
        $this->date = $date;
        $this->info = $info;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getInfo(): Info
    {
        return $this->info;
    }
}
