<?php

declare(strict_types=1);

namespace App\Tests\Builder\Cart;

use App\Model\Cart\Entity\CartOwner\CartOwner;
use App\Model\Cart\Entity\CartOwner\Id;

class CartOwnerBuilder
{
    private $guests_key = 'guests_key';
    private $user_id = null;

    public function build(): CartOwner
    {
        $owner = new CartOwner(
            Id::next(),
            $this->guests_key,
            $this->user_id
        );

        return $owner;
    }
}
