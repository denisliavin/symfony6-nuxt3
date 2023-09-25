<?php

declare(strict_types=1);

namespace App\ReadModel\Product\Category;

use App\Model\Product\Entity\Category\Category;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class CategoryFetcher
{
    private $connection;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Category::class);
    }

    public function find(string $id): ?Category
    {
        return $this->repository->find($id);
    }

    public function all()
    {
        $qb = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('products_categories');


        return $qb->fetchAllAssociative();
    }
}
