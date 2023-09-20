<?php

namespace App\Model\Product\UseCase\Tag\Edit;

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
