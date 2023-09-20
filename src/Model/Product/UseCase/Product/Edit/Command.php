<?php

namespace App\Model\Product\UseCase\Product\Edit;

class Command
{
    public $id;
    public $slug;
    public $category;
    public $brand;
    public $tag;
    public $price;
    public $info;
    public $images = [];
    public $featuresValues = [];

    public function __construct($id)
    {
        $this->price = new \stdClass();
        $this->price->new = 0;
        $this->price->old = 0;

        $this->info = new \stdClass();
        $this->info->name = '';
        $this->info->description = '';
        $this->info->specification = '';

        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
