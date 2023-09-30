<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Brand\Create;

use App\Model\Flusher;
use App\Model\Product\Entity\Brand\Id;
use App\Model\Product\Entity\Brand\Brand;
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
        if ($this->brands->hasBySlug($command->slug)) {
            throw new \DomainException('Brand with this slug already exists.');
        }

        $brand = new Brand(
            Id::next(),
            $command->name,
            $command->slug
        );

        $this->brands->add($brand);
        $this->flusher->flush();
    }
}
