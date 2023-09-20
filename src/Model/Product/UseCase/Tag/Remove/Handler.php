<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Tag\Remove;

use App\Model\Flusher;
use App\Model\Product\Entity\Tag\TagRepository;

class Handler
{
    private $tags;
    private $flusher;

    public function __construct(TagRepository $tags, Flusher $flusher)
    {
        $this->tags = $tags;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $category = $this->tags->get($command->id);

        $this->tags->remove($category);

        $this->flusher->flush();
    }
}
