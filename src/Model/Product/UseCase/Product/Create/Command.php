<?php

namespace App\Model\Product\UseCase\Product\Create;

class Command
{
    public $slug;
    public $category;
    public $brand;
    public $tag;
    public $price;
    public $info;

    public function __construct()
    {
        $this->price = new \stdClass();
        $this->price->new = 0;
        $this->price->old = 0;

        $this->info = new \stdClass();
        $this->info->name = '';
        $this->info->description = '';
        $this->info->specification = '';
    }

    public function getId()
    {
        return $this->info->name;
    }
}
