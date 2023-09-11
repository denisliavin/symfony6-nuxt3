<?php

declare(strict_types=1);

namespace App\Model\Feature\Entity\Feature;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'features')]
class Feature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private $name;

    #[ORM\Column(type: 'string', length: 500)]
    private $description;

    /** @var Collection<int, FeatureValue> An ArrayCollection of Bug objects. */
    #[ORM\OneToMany(targetEntity: FeatureValue::class, mappedBy: 'feature')]
    private Collection $values;
}
