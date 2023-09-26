<?php

declare(strict_types=1);

namespace App\Model\Cart\Entity\CartOwner;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;

#[ORM\Entity]
#[ORM\Table(name: 'carts_carts_owners')]
class CartOwner
{
    #[Embedded(class: Id::class)]
    private Id $id;

    #[Column(type: "string", nullable: true)]
    private $guests_key = null;

    #[Column(type: "integer", nullable: true)]
    private $user_id = null;

    public function __construct(Id $id, $guests_key, $user_id)
    {
        $this->id = $id;
        $this->guests_key = $guests_key;
        $this->user_id = $user_id;
    }
}
