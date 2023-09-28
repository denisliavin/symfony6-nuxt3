<?php

namespace App\Model\Cart\UseCase\Cart\Items\Set;

class Command
{
    public $id;
    public $coupon;

    /**
     * @return mixed
     */
    public function __construct($id)
    {
        $this->id = new \stdClass();
        $this->id->value = $id;
    }

    public function getId()
    {
        return $this->id->value;
    }
}
