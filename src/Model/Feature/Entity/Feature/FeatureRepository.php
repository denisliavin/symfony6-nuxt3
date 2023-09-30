<?php

namespace App\Model\Feature\Entity\Feature;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class FeatureRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Feature::class);
        $this->em = $em;
    }

    public function get($id): Feature
    {
        /** @var Feature $feature */
        if (!$feature = $this->repo->find($id)) {
            throw new EntityNotFoundException('Feature is not found.');
        }
        return $feature;
    }

    public function getByValueId($id): Feature
    {
        $feature = $this->repo->createQueryBuilder('t')
                ->innerJoin('t.values', 'v')
                ->andWhere('v.id.value = :id')
                ->setParameter(':id', $id)
                ->getQuery()
                ->getSingleResult();

        /** @var Feature $feature */
        if (!$feature) {
            throw new EntityNotFoundException('Feature is not found.');
        }
        return $feature;
    }

    public function findAll()
    {
        return $this->repo->findAll();
    }

    public function add(Feature $feature): void
    {
        $this->em->persist($feature);
    }

    public function remove(Feature $feature): void
    {
        $this->em->remove($feature);
    }

    public function hasByName($name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id.value)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasByNameAndId($name, $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id.value)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name)
                ->andWhere('t.id.value != :id')
                ->setParameter(':id', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasValueByName($name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id.value)')
                ->innerJoin('t.values', 'v')
                ->andWhere('v.name = :name')
                ->setParameter(':name', $name)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
