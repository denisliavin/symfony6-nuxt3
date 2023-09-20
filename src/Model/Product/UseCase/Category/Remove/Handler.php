<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Category\Remove;

use App\Model\Flusher;
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
        $category = $this->categories->get($command->id);

        $this->categories->remove($category);

        $this->flusher->flush();
    }
}
