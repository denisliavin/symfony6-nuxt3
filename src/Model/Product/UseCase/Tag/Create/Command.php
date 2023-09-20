<?php

namespace App\Model\Product\UseCase\Tag\Create;

class Command
{
    public $name;
    public $slug;

    public function getId()
    {
        return $this->name;
    }
}
