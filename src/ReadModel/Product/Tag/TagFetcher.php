<?php

declare(strict_types=1);

namespace App\ReadModel\Product\Tag;

use App\Model\Product\Entity\Tag\Tag;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class TagFetcher
{
    private $connection;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Tag::class);
    }

    public function find(string $id): ?Tag
    {
        return $this->repository->find($id);
    }

    public function all()
    {
        $qb = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('products_tags');


        return $qb->fetchAllAssociative();
    }
}
