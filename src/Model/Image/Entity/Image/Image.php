<?php

declare(strict_types=1);

namespace App\Model\Image\Entity\Image;

use App\Model\Product\Entity\Product\Product;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\ManyToMany;

#[ORM\Entity]
#[ORM\Table(name: 'images')]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Embedded(class: Info::class)]
    private Info $info;

    #[ManyToMany(targetEntity: Product::class, mappedBy: 'images')]
    private Collection $products;

    public function __construct(Info $info)
    {
        $this->info = $info;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getInfo(): Info
    {
        return $this->info;
    }
}
