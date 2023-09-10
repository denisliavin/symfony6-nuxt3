<?php

namespace App\Model\Coupon\UseCase\Coupon\Update;

class Command
{
    public $id;
    public $name;
    public $code;
    public $sale;

    /**
     * @return mixed
     */
    public function __construct($id)
    {
        $obj = new \stdClass();
        $obj->type = '';
        $obj->value = null;

        $this->id = $id;
        $this->sale = $obj;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSale()
    {
        return $this->sale;
    }
}
