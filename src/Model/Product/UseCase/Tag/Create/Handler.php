<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Tag\Create;

use App\Model\Flusher;
use App\Model\Product\Entity\Tag\Tag;
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
        if ($this->tags->hasBySlug($command->slug)) {
            throw new \DomainException('Tag with this slug already exists.');
        }

        $tag = new Tag(
            $command->name,
            $command->slug
        );

        $this->tags->add($tag);
        $this->flusher->flush();
    }
}
