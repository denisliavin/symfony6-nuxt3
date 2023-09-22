<?php

namespace App\Model\Product\UseCase\Product\Images\Create;

class Command
{
    public $name;
    public $product_id;

    public function __construct()
    {
        if (isset($_GET['product_id'])) {
            $this->product_id = $_GET['product_id'];
        }
    }

    public function getId()
    {
        return $this->name;
    }

    public function getName()
    {
        return $this->name;
    }
}
