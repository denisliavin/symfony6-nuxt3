<?php

namespace App\Model\Coupon\UseCase\Coupon\Create;

class Command
{
    public $name;
    public $code;
    public $sale;

    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->sale = new \stdClass();
        $this->sale->type = '';
        $this->sale->value = null;
    }

    public function getId()
    {
        return $this->name;
    }
}
