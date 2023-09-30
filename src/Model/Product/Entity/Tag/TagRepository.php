<?php

namespace App\Model\Product\Entity\Tag;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class TagRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Tag::class);
        $this->em = $em;
    }

    public function get($id): Tag
    {
        /** @var Tag $tag */
        if (!$tag = $this->repo->find($id)) {
            throw new EntityNotFoundException('Tag is not found.');
        }
        return $tag;
    }

    public function add(Tag $tag): void
    {
        $this->em->persist($tag);
    }

    public function remove(Tag $tag): void
    {
        $this->em->remove($tag);
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
