<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Product\Edit;

use App\Model\Flusher;
use App\Model\Product\Entity\Product\Info;
use App\Model\Product\Entity\Product\Price;
use App\Model\Product\Entity\Product\ProductRepository;

class Handler
{
    private $products;
    private $flusher;

    public function __construct(
        ProductRepository $products,
        Flusher $flusher
    )
    {
        $this->products = $products;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $product = $this->products->get($command->id);

        if ($this->products->hasBySlugAndId($command->slug, $command->id)) {
            throw new \DomainException('Product with this slug already exists.');
        }

        $product->edit(
            $command->slug,
            $command->category,
            $command->brand,
            $command->tag,
            new Price($command->price->new, $command->price->old),
            new Info($command->info->name, $command->info->description, $command->info->specification),
            $command->featuresValues
        );

        $this->flusher->flush();
    }
}
