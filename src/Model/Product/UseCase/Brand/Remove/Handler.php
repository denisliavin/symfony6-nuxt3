<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Brand\Remove;

use App\Model\Flusher;
use App\Model\Product\Entity\Brand\BrandRepository;

class Handler
{
    private $brands;
    private $flusher;

    public function __construct(BrandRepository $brands, Flusher $flusher)
    {
        $this->brands = $brands;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $category = $this->brands->get($command->id);

        $this->brands->remove($category);

        $this->flusher->flush();
    }
}
