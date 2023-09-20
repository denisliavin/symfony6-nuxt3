<?php

namespace App\Model\Product\Entity\Category;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class CategoryRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Category::class);
        $this->em = $em;
    }

    public function get($id): Category
    {
        /** @var Category $category */
        if (!$category = $this->repo->find($id)) {
            throw new EntityNotFoundException('Category is not found.');
        }
        return $category;
    }

    public function add(Category $category): void
    {
        $this->em->persist($category);
    }

    public function remove(Category $category): void
    {
        $this->em->remove($category);
    }

    public function hasBySlug($slug): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.slug = :slug')
                ->setParameter(':slug', $slug)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasBySlugAndId($slug, $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.slug = :slug')
                ->setParameter(':slug', $slug)
                ->andWhere('t.id != :id')
                ->setParameter(':id', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
