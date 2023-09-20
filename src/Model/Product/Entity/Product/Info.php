<?php

namespace App\Model\Product\Entity\Product;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

#[Embeddable]
class Info
{
    #[Column(type: 'string')]
    private $name;

    #[Column(type: 'string', length: 1000)]
    private $description;

    #[Column(type: 'string', length: 1000)]
    private $specification;

    public function __construct($name, $description, $specification)
    {
        Assert::notEmpty($name);
        Assert::notEmpty($description);
        Assert::notEmpty($specification);

        $this->name = $name;
        $this->description = $description;
        $this->specification = $specification;
    }

    public function edit($name, $description, $specification)
    {
        Assert::notEmpty($name);
        Assert::notEmpty($description);
        Assert::notEmpty($specification);

        $this->name = $name;
        $this->description = $description;
        $this->specification = $specification;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSpecification()
    {
        return $this->specification;
    }
}
