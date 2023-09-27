<?php

declare(strict_types=1);

namespace App\Tests\Builder\Brand;

use App\Model\Product\Entity\Brand\Brand;

class BrandBuilder
{
    private $name = 'Brand name';
    private $slug = 'brand_slug';

    public function build(): Brand
    {
        $brand = new Brand(
            $this->name,
            $this->slug
        );

        return $brand;
    }
}
