<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Category\Create;

use App\Model\Flusher;
use App\Model\Product\Entity\Category\Id;
use App\Model\Product\Entity\Category\Category;
use App\Model\Product\Entity\Category\CategoryRepository;

class Handler
{
    private $categories;
    private $flusher;

    public function __construct(CategoryRepository $categories, Flusher $flusher)
    {
        $this->categories = $categories;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if ($this->categories->hasBySlug($command->slug)) {
            throw new \DomainException('Category with this slug already exists.');
        }

        $category = new Category(
            Id::next(),
            $command->slug,
            $command->icon,
            $command->name
        );

        $this->categories->add($category);
        $this->flusher->flush();
    }
}
