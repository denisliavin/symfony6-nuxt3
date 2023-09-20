<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Tag\Edit;

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
        $tag = $this->tags->get($command->id);

        if ($this->tags->hasBySlugAndId($command->slug, $command->id)) {
            throw new \DomainException('Tag with this code already exists.');
        }

        $tag->edit(
            $command->name,
            $command->slug
        );

        $this->flusher->flush();
    }
}
