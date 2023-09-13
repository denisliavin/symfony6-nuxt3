<?php

namespace App\Model\Feature\UseCase\Feature\Value\Detach;

class Command
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
