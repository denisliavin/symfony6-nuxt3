<?php

declare(strict_types=1);

namespace App\Model\Cart\UseCase\Cart\Items\Remove;

class Command
{
    public $cart_id;
    public $id;

    public function __construct(string $id)
    {
        $this->cart_id = $_GET['cart_id'];
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
