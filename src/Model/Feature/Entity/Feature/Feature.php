<?php

declare(strict_types=1);

namespace App\Model\Feature\Entity\Feature;

use App\Model\Feature\Entity\FeatureValue\Id as FeatureValueId;
use App\Model\Feature\Entity\FeatureValue\FeatureValue;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'features')]
class Feature
{
    #[ORM\Embedded(class: Id::class)]
    private Id $id;

    #[ORM\Column(type: 'string')]
    private $name;

    #[ORM\Column(type: 'string', length: 500)]
    private $description;

    /** @var Collection<int, FeatureValue> An ArrayCollection of Bug objects. */
    #[ORM\OneToMany(targetEntity: FeatureValue::class, mappedBy: 'feature', cascade: ["persist"], orphanRemoval: true)]
    private Collection $values;

    public function __construct(Id $id, $name, $description)
    {
        Assert::notEmpty($name);

        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->values = new ArrayCollection();
    }

    public function edit($name, $description)
    {
        Assert::notEmpty($name);

        $this->name = $name;
        $this->description = $description;
    }

    public function attachValue($name): void
    {
        foreach ($this->values as $value) {
            if ($value->getName() == $name) {
                throw new \DomainException('Value is already attached.');
            }
        }

        $this->values->add(new FeatureValue(FeatureValueId::next(), $name, $this));
    }

    public function editValue($value_id, $name): void
    {
        foreach ($this->values as $value) {
            if ($value->getId() == $value_id) {
                $value->edit($name);
                return;
            }
        }

        throw new \DomainException('Value is not edited.');
    }

    public function detachValue($value_id): void
    {
        foreach ($this->values as $value) {
            if ($value->getId() == $value_id) {
                $this->values->removeElement($value);
                return;
            }
        }
        throw new \DomainException('Value is not detached.');
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getValues(): ArrayCollection|Collection
    {
        return $this->values;
    }
}
