<?php

namespace App\Model\Cart\Entity\CartOwner;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class CartOwnerRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(CartOwner::class);
        $this->em = $em;
    }

    public function get($id): CartOwner
    {
        /** @var CartOwner $cartOwner */
        if (!$cartOwner = $this->repo->find($id)) {
            throw new EntityNotFoundException('CartOwner is not found.');
        }
        return $cartOwner;
    }

    public function add(CartOwner $cartOwner): void
    {
        $this->em->persist($cartOwner);
    }

    public function remove(CartOwner $cartOwner): void
    {
        $this->em->remove($cartOwner);
    }
}
