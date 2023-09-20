<?php

namespace App\Model\Product\UseCase\Brand\Create;

class Command
{
    public $name;
    public $slug;

    public function getId()
    {
        return $this->name;
    }
}
