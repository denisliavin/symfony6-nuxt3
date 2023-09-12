<?php

namespace App\Model\Feature\UseCase\Feature\Create;

class Command
{
    public $name;
    public $description;

    public function getId()
    {
        return $this->name;
    }
}
