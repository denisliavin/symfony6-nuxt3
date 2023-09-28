<?php

declare(strict_types=1);

namespace App\Tests\Builder\Category;

use App\Model\Product\Entity\Category\Category;
use App\Model\Product\Entity\Category\Id;

class CategoryBuilder
{
    private $slug = 'Category slug';
    private $icon = 'Category icon';
    private $name = 'Category name';

    public function build(): Category
    {
        $category = new Category(
            Id::next(),
            $this->slug,
            $this->icon,
            $this->name
        );

        return $category;
    }
}
