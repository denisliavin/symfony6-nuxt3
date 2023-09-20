<?php

namespace App\Model\Product\UseCase\Category\Edit;

class Command
{
    public $id;
    public $name;
    public $slug;
    public $icon;

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
