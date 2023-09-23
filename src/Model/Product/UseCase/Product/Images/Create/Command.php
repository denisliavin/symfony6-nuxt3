<?php

namespace App\Model\Product\UseCase\Product\Images\Create;

class Command
{
    public $info;
    public $product_id;

    public function __construct()
    {
        if (isset($_GET['product_id'])) {
            $this->product_id = $_GET['product_id'];
        }

        $this->info = new \stdClass();
        $this->info->name = '';
    }

    public function getId()
    {
        return $this->info->name;
    }

    public function getInfo()
    {
        return $this->info;
    }
}
