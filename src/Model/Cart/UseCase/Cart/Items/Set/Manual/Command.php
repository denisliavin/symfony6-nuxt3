<?php

namespace App\Model\Cart\UseCase\Cart\Items\Set\Manual;

class Command
{
    public $id;
    public $quantity;
    public $cart;

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
