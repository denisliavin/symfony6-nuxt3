<?php

declare(strict_types=1);

namespace App\Model\Feature\UseCase\Feature\Remove;

class Command
{
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
