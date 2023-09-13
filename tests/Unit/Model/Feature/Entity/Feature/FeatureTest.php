<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Feature\Entity\Feature;

use App\Model\Feature\Entity\Feature\Feature;
use App\Tests\Builder\Feature\FeatureBuilder;
use PHPUnit\Framework\TestCase;

class FeatureTest extends TestCase
{
    public function testCreate(): void
    {
        $feature = new Feature(
            $name = 'name',
            $description = 'description'
        );

        self::assertEquals($name, $feature->getName());
        self::assertEquals($description, $feature->getDescription());
    }

    public function testEdit(): void
    {
        $feature = (new FeatureBuilder())->build();
        $feature->edit(
            $name = 'name',
            $description = 'description'
        );

        self::assertEquals($name, $feature->getName());
        self::assertEquals($description, $feature->getDescription());
    }

    public function testAttachValue(): void
    {
        $feature = (new FeatureBuilder())->build();
        $feature->edit(
            $name = 'name',
            $description = 'description'
        );

        self::assertEquals($name, $feature->getName());
        self::assertEquals($description, $feature->getDescription());
    }
}
