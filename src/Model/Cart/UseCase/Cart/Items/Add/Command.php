<?php

namespace App\Model\Cart\UseCase\Cart\Items\Add;

class Command
{
    public $cart_id;
    public $product;
    public $features;
    public $quantity;

    public function __construct()
    {
        if (isset($_GET['cart_id'])) {
            $this->cart_id = $_GET['cart_id'];
        }
    }

    public function getId()
    {
        return $this->quantity;
    }
}
