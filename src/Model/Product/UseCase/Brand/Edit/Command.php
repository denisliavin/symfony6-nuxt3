<?php

namespace App\Model\Product\UseCase\Brand\Edit;

class Command
{
    public $id;
    public $name;
    public $slug;

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
