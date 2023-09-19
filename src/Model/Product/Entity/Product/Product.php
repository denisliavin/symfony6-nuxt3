<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product;

use App\Model\Feature\Entity\Feature\FeatureValue;
use App\Model\Image\Entity\Image\Image;
use App\Model\Product\Entity\Brand\Brand;
use App\Model\Product\Entity\Category\Category;
use App\Model\Product\Entity\Tag\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'products_products')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private $slug;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'product')]
    private Category|null $category = null;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'product')]
    private Brand|null $brand = null;

    #[ORM\ManyToOne(targetEntity: Tag::class, inversedBy: 'product')]
    private Tag|null $tag = null;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    private $rating;

    #[Embedded(class: Price::class)]
    private Price $price;

    #[Embedded(class: Info::class)]
    private Info $info;

    #[ORM\JoinTable(name: 'products_products_images')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'image_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Image::class)]
    private Collection $images;

    #[ORM\JoinTable(name: 'products_products_features_values')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'feature_value_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: FeatureValue::class)]
    private Collection $featuresValues;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->featuresValues = new ArrayCollection();
    }

    public function edit($slug, $name)
    {
        Assert::notEmpty($slug);
        Assert::notEmpty($name);

        $this->slug = $slug;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSlug()
    {
        return $this->slug;
    }
}
