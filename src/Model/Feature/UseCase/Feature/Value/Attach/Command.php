<?php

namespace App\Model\Feature\UseCase\Feature\Value\Attach;

class Command
{
    public $name;
    public $feature_id;

    public function getId()
    {
        return $this->name;
    }
}
