<?php

namespace App\Repository\Model\Test\Entity;

use App\Model\Test\Entity\Test2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Test2>
 *
 * @method Test2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Test2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Test2[]    findAll()
 * @method Test2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Test2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Test2::class);
    }

//    /**
//     * @return Test2[] Returns an array of Test2 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Test2
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
