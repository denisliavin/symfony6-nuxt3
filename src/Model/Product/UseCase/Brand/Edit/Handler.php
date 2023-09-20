<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Brand\Edit;

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
        $brand = $this->brands->get($command->id);

        if ($this->brands->hasBySlugAndId($command->slug, $command->id)) {
            throw new \DomainException('Brand with this code already exists.');
        }

        $brand->edit(
            $command->name,
            $command->slug
        );

        $this->flusher->flush();
    }
}
