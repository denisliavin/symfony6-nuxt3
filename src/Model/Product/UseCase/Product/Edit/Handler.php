<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Product\Edit;

use App\Model\Flusher;
use App\Model\Product\Entity\Brand\BrandRepository;
use App\Model\Product\Entity\Category\CategoryRepository;
use App\Model\Product\Entity\Product\Info;
use App\Model\Product\Entity\Product\Price;
use App\Model\Product\Entity\Product\Product;
use App\Model\Product\Entity\Product\ProductRepository;
use App\Model\Product\Entity\Tag\TagRepository;

class Handler
{
    private $categories;
    private $brands;
    private $tags;
    private $products;
    private $flusher;

    public function __construct(
        CategoryRepository $categories,
        BrandRepository $brands,
        TagRepository $tags,
        ProductRepository $products,
        Flusher $flusher
    )
    {
        $this->categories = $categories;
        $this->brands = $brands;
        $this->tags = $tags;
        $this->products = $products;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $product = $this->products->get($command->id);

        if ($this->products->hasBySlugAndId($command->slug, $command->id)) {
            throw new \DomainException('Product with this slug already exists.');
        }

        $category = $this->categories->get($command->category);
        $brand = $command->brand ? $this->brands->get($command->brand) : null;
        $tag = $command->tag ? $this->tags->get($command->tag) : null;

        $product->edit(
            $command->slug,
            $category,
            $brand,
            $tag,
        new Price($command->price->new, $command->price->old),
        new Info($command->info->name, $command->info->description, $command->info->specification)
        );

        $this->flusher->flush();
    }
}
