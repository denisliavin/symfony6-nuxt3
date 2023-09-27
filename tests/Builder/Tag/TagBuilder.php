<?php

declare(strict_types=1);

namespace App\Tests\Builder\Tag;

use App\Model\Product\Entity\Tag\Tag;

class TagBuilder
{
    private $slug = 'tag_slug';
    private $name = 'Tag name';

    public function build(): Tag
    {
        $tag = new Tag(
            $this->name,
            $this->slug
        );

        return $tag;
    }
}
