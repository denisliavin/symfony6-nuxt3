<?php

declare(strict_types=1);

namespace App\Model\Feature\Entity\Feature;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

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

    public function __construct($name, $feature)
    {
        Assert::notEmpty($name);

        $this->name = $name;
        $this->feature = $feature;
    }

    public function edit($name)
    {
        Assert::notEmpty($name);

        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFeatureId()
    {
        return $this->feature->getId();
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Feature|null
     */
    public function getFeature(): ?Feature
    {
        return $this->feature;
    }
}
