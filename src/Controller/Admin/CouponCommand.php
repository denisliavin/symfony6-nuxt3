<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;

class CouponCommand
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

    public function getSale()
    {
        return $this->sale;
    }
}
