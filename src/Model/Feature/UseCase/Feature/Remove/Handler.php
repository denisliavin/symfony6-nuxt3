<?php

declare(strict_types=1);

namespace App\Model\Feature\UseCase\Feature\Remove;

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
        $coupon = $this->features->get($command->id);

        $this->features->remove($coupon);

        $this->flusher->flush();
    }
}
