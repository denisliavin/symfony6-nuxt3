<?php

namespace App\Model\Feature\UseCase\Feature\Edit;

class Command
{
    public $id;
    public $name;
    public $description;

    /**
     * @return mixed
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
