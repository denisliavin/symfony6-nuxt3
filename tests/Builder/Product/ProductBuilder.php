<?php

declare(strict_types=1);

namespace App\Tests\Builder\Product;

use App\Model\Product\Entity\Product\Id;
use App\Model\Product\Entity\Product\Info;
use App\Model\Product\Entity\Product\Price;
use App\Model\Product\Entity\Product\Product;
use App\Tests\Builder\Brand\BrandBuilder;
use App\Tests\Builder\Category\CategoryBuilder;
use App\Tests\Builder\Tag\TagBuilder;

class ProductBuilder
{
    private $slug = 'product_slug';
    private $name = 'Product name';
    private $description = 'Product description';
    private $specification = 'Product specification';
    private $priceNew = 30;
    private $priceOld = 40;
    private $category;
    private $brand;
    private $tag;

    public function __construct()
    {
        $this->category = (new CategoryBuilder())->build();
        $this->brand = (new BrandBuilder())->build();
        $this->tag = (new TagBuilder())->build();
    }

    public function build(): Product
    {
        $product = new Product(
            Id::next(),
            $this->slug,
            $this->category,
            $this->brand,
            $this->tag,
            new Price($this->priceNew, $this->priceOld),
            new Info($this->name, $this->description, $this->specification)
        );

        return $product;
    }
}
