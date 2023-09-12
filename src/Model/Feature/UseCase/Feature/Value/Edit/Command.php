<?php

namespace App\Model\Feature\UseCase\Feature\Value\Edit;

class Command
{
    public $id;
    public $name;
    public $feature_id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
