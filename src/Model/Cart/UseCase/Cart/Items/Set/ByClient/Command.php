<?php

namespace App\Model\Cart\UseCase\Cart\Items\Set\ByClient;
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
    public $quantity = 1;
    /**
     * @Assert\NotBlank()
     */
    public $key;

    public $user_id;

    public function __construct(string $item_id, int $quantity, string $key)
    {
        $this->item_id = $item_id;
        $this->quantity = $quantity;
        $this->key = $key;
    }
}
