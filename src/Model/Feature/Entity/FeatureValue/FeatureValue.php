<?php

declare(strict_types=1);

namespace App\Model\Feature\Entity\FeatureValue;

use App\Model\Feature\Entity\Feature\Feature;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'features_values')]
class FeatureValue
{
    #[ORM\Embedded(class: Id::class)]
    private Id $id;

    #[ORM\Column(type: 'string')]
    private $name;

    #[ORM\ManyToOne(targetEntity: Feature::class, inversedBy: 'values')]
    #[ORM\JoinColumn(name: 'feature_id', referencedColumnName: 'id_value')]
    private Feature|null $feature = null;

    public function __construct(Id $id, $name, $feature)
    {
        Assert::notEmpty($name);

        $this->id = $id;
        $this->name = $name;
        $this->feature = $feature;
    }

    public function edit($name)
    {
        Assert::notEmpty($name);

        $this->name = $name;
    }

    public function getId(): Id
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

    public function __toString()
    {
        return $this->name . ' (' . $this->getFeature()->getName() . ')';
    }
}
