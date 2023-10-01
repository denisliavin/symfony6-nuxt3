<?php

declare(strict_types=1);

namespace App\ReadModel\Product\Brand;

use App\Model\Product\Entity\Brand\Brand;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class BrandFetcher
{
    private $connection;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Brand::class);
    }

    public function find(string $id): ?Brand
    {
        return $this->repository->find($id);
    }

    public function all()
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                '*',
                '(SELECT COUNT(*) FROM products_products p WHERE p.brand_id = pb.id_value) AS products'
            )
            ->from('products_brands pb');


        return $qb->fetchAllAssociative();
    }
}
