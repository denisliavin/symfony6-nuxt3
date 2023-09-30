<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Category;

use App\Model\Product\Entity\Product\Product;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'products_categories')]
class Category
{
    #[ORM\Embedded(class: Id::class)]
    private Id $id;

    #[ORM\Column(type: 'string')]
    private $slug;

    #[ORM\Column(type: 'string')]
    private $icon;

    #[ORM\Column(type: 'string')]
    private $name;

    /** @var Collection<int, Product> An ArrayCollection of Bug objects. */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category', cascade: ["persist"], orphanRemoval: true)]
    private Collection $products;

    public function __construct(Id $id, $slug, $icon, $name)
    {
        Assert::notEmpty($slug);
        Assert::notEmpty($icon);
        Assert::notEmpty($name);

        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->icon = $icon;
    }

    public function edit($slug, $icon, $name)
    {
        Assert::notEmpty($slug);
        Assert::notEmpty($icon);
        Assert::notEmpty($name);

        $this->name = $name;
        $this->slug = $slug;
        $this->icon = $icon;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function __toString()
    {
        return $this->name;
    }
}
