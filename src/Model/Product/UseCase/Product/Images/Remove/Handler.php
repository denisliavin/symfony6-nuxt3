<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Product\Images\Remove;

use App\Model\Flusher;
use App\Model\Image\Entity\Image\ImageRepository;
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
        if (!isset($_GET['product_id'])) {
            throw new \DomainException('Bad data');
        }

        $product = $this->products->get($_GET['product_id']);
        $image = $this->images->get($command->getId());

        $product->removeImage($image);
        $this->flusher->flush($product);
    }
}
