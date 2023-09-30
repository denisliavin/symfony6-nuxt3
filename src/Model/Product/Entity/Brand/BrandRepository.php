<?php

namespace App\Model\Product\Entity\Brand;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class BrandRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Brand::class);
        $this->em = $em;
    }

    public function get($id): Brand
    {
        /** @var Brand $brand */
        if (!$brand = $this->repo->find($id)) {
            throw new EntityNotFoundException('Brand is not found.');
        }
        return $brand;
    }

    public function add(Brand $brand): void
    {
        $this->em->persist($brand);
    }

    public function remove(Brand $brand): void
    {
        $this->em->remove($brand);
    }

    public function hasBySlug($slug): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id.value)')
                ->andWhere('t.slug = :slug')
                ->setParameter(':slug', $slug)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasBySlugAndId($slug, $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id.value)')
                ->andWhere('t.slug = :slug')
                ->setParameter(':slug', $slug)
                ->andWhere('t.id.value != :id')
                ->setParameter(':id', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
