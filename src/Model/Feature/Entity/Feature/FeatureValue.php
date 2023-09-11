<?php

declare(strict_types=1);

namespace App\Model\Feature\Entity\Feature;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'features_values')]
class FeatureValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private $name;

    #[ORM\ManyToOne(targetEntity: Feature::class, inversedBy: 'values')]
    private Feature|null $feature = null;
}
