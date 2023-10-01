<?php

namespace App\Model\Feature\UseCase\Feature\Value\Attach;

class Command
{
    public $name;
    public $feature_id;

    public function __construct()
    {
        if (isset($_GET['feature_id']) && $_GET['feature_id']) {
            $this->feature_id = $_GET['feature_id'];
        }
    }

    public function getId()
    {
        return $this->name;
    }
}
