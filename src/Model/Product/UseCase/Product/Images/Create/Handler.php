<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Product\Images\Create;

use App\Model\Flusher;
use App\Model\Image\Entity\Image\Image;
use App\Model\Image\Entity\Image\Info;
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
        $product = $this->products->get($command->product_id);
        $image = new Image(new Info('products', $command->info->name));

        $product->addImage($image);
        $this->flusher->flush();
    }
}
