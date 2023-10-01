<?php

namespace App\Model\Cart\UseCase\Cart\Items\Add\ByClient;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $product_id;

    public $featuresValues;
    /**
     * @Assert\NotBlank()
     */
    public $quantity = 1;
    /**
     * @Assert\NotBlank()
     */
    public $key;

    public $user_id;

    public function __construct(string $product_id, array $featuresValues, string $key)
    {
        $this->product_id = $product_id;
        $this->featuresValues = $featuresValues;
        $this->key = $key;
    }
}
