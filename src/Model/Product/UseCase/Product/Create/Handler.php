<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Product\Create;

use App\Model\Flusher;
use App\Model\Product\Entity\Product\Id;
use App\Model\Product\Entity\Product\Info;
use App\Model\Product\Entity\Product\Price;
use App\Model\Product\Entity\Product\Product;
use App\Model\Product\Entity\Product\ProductRepository;

class Handler
{
    private $products;
    private $flusher;

    public function __construct(ProductRepository $products, Flusher $flusher)
    {
        $this->products = $products;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if ($this->products->hasBySlug($command->slug)) {
            throw new \DomainException('Product with this slug already exists.');
        }

        $product = new Product(
            Id::next(),
            $command->slug,
            $command->category,
            $command->brand,
            $command->tag,
            new Price($command->price->new, $command->price->old),
            new Info($command->info->name, $command->info->description, $command->info->specification)
        );

        $this->products->add($product);
        $this->flusher->flush();
    }
}
