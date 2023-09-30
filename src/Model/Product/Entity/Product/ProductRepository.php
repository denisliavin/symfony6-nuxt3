<?php

namespace App\Model\Product\Entity\Product;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class ProductRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Product::class);
        $this->em = $em;
    }

    public function get($id): Product
    {
        /** @var Product $product */
        if (!$product = $this->repo->find($id)) {
            throw new EntityNotFoundException('Product is not found.');
        }
        return $product;
    }

    public function add(Product $product): void
    {
        $this->em->persist($product);
    }

    public function remove(Product $product): void
    {
        $this->em->remove($product);
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
