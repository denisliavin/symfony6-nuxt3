<?php

namespace App\Model\Product\Entity\Product;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Price
{
    #[Column(type: 'decimal', precision: 8, scale: 2)]
    private $new;

    #[Column(type: 'decimal', precision: 8, scale: 2)]
    private $old;

    public function __construct($new, $old)
    {
        if (
            $new < 0 ||
            $old < 0 ||
            $new >= $old
        ) {
            throw new \DomainException('Bad price!');
        }

        $this->new = $new;
        $this->old = $old;
    }

    public function edit($new, $old)
    {
        if (
            $new < 0 ||
            $old < 0 ||
            $new >= $old
        ) {
            throw new \DomainException('Bad price!');
        }

        $this->new = $new;
        $this->old = $old;
    }

    public function getNew()
    {
        return $this->new;
    }

    public function getOld()
    {
        return $this->old;
    }
}
