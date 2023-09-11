<?php

namespace App\Model\Coupon\Entity\Coupon;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class CouponRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Coupon::class);
        $this->em = $em;
    }

    public function get($id): Coupon
    {
        /** @var Coupon $coupon */
        if (!$coupon = $this->repo->find($id)) {
            throw new EntityNotFoundException('Coupon is not found.');
        }
        return $coupon;
    }

    public function add(Coupon $coupon): void
    {
        $this->em->persist($coupon);
    }

    public function remove(Coupon $coupon): void
    {
        $this->em->remove($coupon);
    }

    public function hasByCode($code): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.code = :code')
                ->setParameter(':code', $code)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasByCodeAndId($code, $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.code = :code')
                ->setParameter(':code', $code)
                ->andWhere('t.id != :id')
                ->setParameter(':id', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
