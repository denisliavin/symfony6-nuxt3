<?php

declare(strict_types=1);

namespace App\Tests\Builder\Feature;

use App\Model\Feature\Entity\Feature\Feature;
use App\Model\Feature\Entity\Feature\Id;

class FeatureBuilder
{
    private $name = 'Feature name';
    private $description = 'Feature code';

    public function build(): Feature
    {
        $feature = new Feature(
            Id::next(),
            $this->name,
            $this->description
        );

        return $feature;
    }
}
