<?php

namespace App\Model\Cart\UseCase\Cart\Items\Remove\ByClient;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $item_id;
    /**
     * @Assert\NotBlank()
     */
    public $key;

    public $user_id;

    public function __construct(string $item_id, string $key)
    {
        $this->item_id = $item_id;
        $this->key = $key;
    }
}
