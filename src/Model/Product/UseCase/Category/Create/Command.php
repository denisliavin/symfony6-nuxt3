<?php

namespace App\Model\Product\UseCase\Category\Create;

class Command
{
    public $name;
    public $slug;
    public $icon;


    public function getId()
    {
        return $this->name;
    }
}
