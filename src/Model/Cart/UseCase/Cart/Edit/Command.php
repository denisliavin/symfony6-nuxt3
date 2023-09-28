<?php

namespace App\Model\Cart\UseCase\Cart\Edit;

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
