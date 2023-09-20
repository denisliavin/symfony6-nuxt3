<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product;

use App\Model\Feature\Entity\Feature\FeatureValue;
use App\Model\Image\Entity\Image\Image;
use App\Model\Product\Entity\Brand\Brand;
use App\Model\Product\Entity\Category\Category;
use App\Model\Product\Entity\Tag\Tag;
use App\Model\Work\Entity\Projects\Project\Department\Department;
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

    #[Embedded(class: Status::class)]
    private Status $status;

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

    public function __construct(
        $slug,
        Category $category,
        ?Brand $brand,
        ?Tag $tag,
        Price $price,
        Info $info
    )
    {
        Assert::notEmpty($slug);

        $this->slug = $slug;
        $this->category = $category;
        $this->brand = $brand;
        $this->tag = $tag;
        $this->rating = 0.00;
        $this->price = $price;
        $this->info = $info;
        $this->status = new Status(Status::TYPE_DISABLED);

        $this->images = new ArrayCollection();
        $this->featuresValues = new ArrayCollection();
    }

    public function edit(
        $slug,
        Category $category,
        ?Brand $brand,
        ?Tag $tag,
        Price $price,
        Info $info,
        $images,
        $featuresValues
    )
    {
        Assert::notEmpty($slug);

        $this->slug = $slug;
        $this->category = $category;
        $this->brand = $brand;
        $this->tag = $tag;
        $this->price = $price;
        $this->info = $info;

        //$this->images = $images;

        $current = $this->featuresValues->toArray();
        $new = $featuresValues;

        $compare = static function (FeatureValue $a, FeatureValue $b): int {
            return $a->getId() <=> $b->getId();
        };

        foreach (array_udiff($current, $new, $compare) as $item) {
            $this->featuresValues->removeElement($item);
        }

        foreach (array_udiff($new, $current, $compare) as $item) {
            $this->featuresValues->add($item);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getInfo(): Info
    {
        return $this->info;
    }

    public function getFeaturesValues(): ArrayCollection|Collection
    {
        return $this->featuresValues;
    }

    public function getImages(): ArrayCollection|Collection
    {
        return $this->images;
    }

    public function getImagesAdmin()
    {
        return [];
    }
}
