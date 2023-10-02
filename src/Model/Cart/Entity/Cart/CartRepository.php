<?php

namespace App\Model\Cart\Entity\Cart;

use App\Model\Cart\Entity\CartOwner\CartOwner;
use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class CartRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Cart::class);
        $this->em = $em;
    }

    public function get($id): Cart
    {
        /** @var Cart $cart */
        if (!$cart = $this->repo->find($id)) {
            throw new EntityNotFoundException('Cart is not found.');
        }
        return $cart;
    }

    public function add(Cart $cart): void
    {
        $this->em->persist($cart);
    }

    public function remove(Cart $cart): void
    {
        $this->em->remove($cart);
    }

    public function findByIdOrKey($userId, $guests_key): Cart|null
    {
        if (!$userId && !$guests_key) {
            return null;
        }

         $query = $this->repo->createQueryBuilder('c')
                ->select('c')
                ->innerJoin('c.owner', 'o');

         if ($userId) {
             $query->andWhere('o.user_id = :id')->setParameter('id', $userId);
         }

        if ($guests_key) {
            $query->andWhere('o.guests_key = :guests_key')->setParameter('guests_key', $guests_key);
        }

        return $query->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
}
