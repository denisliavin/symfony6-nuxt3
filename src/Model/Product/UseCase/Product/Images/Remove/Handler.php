<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Product\Images\Remove;

use App\Model\Flusher;
use App\Model\Image\Entity\Image\ImageRepository;
use App\Model\Product\Entity\Brand\BrandRepository;
use App\Model\Product\Entity\Product\ProductRepository;

class Handler
{
    private $products;
    private $images;
    private $flusher;

    public function __construct(
        ProductRepository $products,
        ImageRepository $images,
        Flusher $flusher
    )
    {
        $this->products = $products;
        $this->images = $images;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $product = $this->products->get(1);
        $image = $this->images->get($command->getId());

        $product->removeImage($image);

        $this->flusher->flush($product);
    }
}
