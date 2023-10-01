<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product;

use App\Model\AggregateRoot;
use App\Model\Cart\Entity\CartItem\CartItem;
use App\Model\EventsTrait;
use App\Model\Feature\Entity\FeatureValue\FeatureValue;
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
class Product implements AggregateRoot
{
    use EventsTrait;

    #[ORM\Embedded(class: Id::class)]
    private Id $id;

    #[ORM\Column(type: 'string')]
    private $slug;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'product')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id_value')]
    private Category|null $category = null;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'product')]
    #[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id_value')]
    private Brand|null $brand = null;

    #[ORM\ManyToOne(targetEntity: Tag::class, inversedBy: 'product')]
    #[ORM\JoinColumn(name: 'tag_id', referencedColumnName: 'id_value')]
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
    #[ORM\ManyToMany(targetEntity: Image::class, inversedBy: 'products', cascade: ["persist"], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id_value')]
    #[ORM\InverseJoinColumn(name: 'image_id', referencedColumnName: 'id_value')]
    private Collection $images;

    #[ORM\JoinTable(name: 'products_products_features_values')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id_value')]
    #[ORM\InverseJoinColumn(name: 'feature_value_id', referencedColumnName: 'id_value')]
    #[ORM\ManyToMany(targetEntity: FeatureValue::class)]
    private Collection $featuresValues;

    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'product')]
    private Collection $cartItems;

    public function __construct(
        Id $id,
        $slug,
        Category $category,
        ?Brand $brand,
        ?Tag $tag,
        Price $price,
        Info $info
    )
    {
        Assert::notEmpty($slug);

        $this->id = $id;
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

    public function addFeatureValue(FeatureValue $featureValue)
    {
        $this->featuresValues->add($featureValue);
    }

    public function addImage(Image $image)
    {
        $this->images->add($image);
    }

    public function removeImage(Image $imageOutside): void
    {
        foreach ($this->images as $image) {
            if ($image->getId() == $imageOutside->getId()) {
                $this->images->removeElement($image);
                $this->recordEvent(new Event\ProductImageRemoved($image->getInfo()));
                return;
            }
        }
        throw new \DomainException('Image is not found.');
    }

    public function getId(): Id
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
}
