<?php

declare(strict_types=1);

namespace App\Model\Feature\UseCase\Feature\Create;

use App\Model\Feature\Entity\Feature\Id;
use App\Model\Feature\Entity\Feature\Feature;
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
        if ($this->features->hasByName($command->name)) {
            throw new \DomainException('Feature with this name already exists.');
        }

        $feature = new Feature(
            Id::next(),
            $command->name,
            $command->description
        );

        $this->features->add($feature);
        $this->flusher->flush();
    }
}
