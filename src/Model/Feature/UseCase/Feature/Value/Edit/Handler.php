<?php

declare(strict_types=1);

namespace App\Model\Feature\UseCase\Feature\Value\Edit;

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
        $feature = $this->features->get($command->feature_id);

        if ($this->features->hasValueByName($command->name)) {
            throw new \DomainException('Feature with this code already exists.');
        }

        $feature->editValue($command->id, $command->name);
        $this->flusher->flush();
    }
}
