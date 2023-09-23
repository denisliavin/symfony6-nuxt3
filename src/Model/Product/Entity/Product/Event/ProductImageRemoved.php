<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Event;

use App\Model\Image\Entity\Image\Info;

class ProductImageRemoved
{
    public $info;

    public function __construct(Info $info)
    {
        $this->info = $info;
    }
}
