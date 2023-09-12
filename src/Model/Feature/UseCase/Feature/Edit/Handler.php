<?php

declare(strict_types=1);

namespace App\Model\Feature\UseCase\Feature\Edit;

use App\Model\Feature\Entity\Feature\FeatureRepository;
use App\Model\Flusher;

class Handler
{
    private $features;
    private $flusher;

    public function __construct(FeatureRepository $features, Flusher $flusher)
    {
        $this->features = $features;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $feature = $this->features->get($command->id);

        if ($this->features->hasByNameAndId($command->name, $command->id)) {
            throw new \DomainException('Feature with this name already exists.');
        }

        $feature->edit(
            $command->name,
            $command->description
        );

        $this->flusher->flush();
    }
}
