<?php

declare(strict_types=1);

namespace App\ReadModel\Product;

use App\Model\Product\Entity\Product\Product;
use App\ReadModel\Product\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class ProductFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
        $this->repository = $em->getRepository(Product::class);
    }

    public function find(string $id): ?Product
    {
        return $this->repository->find($id);
    }

    /**
     * @param Filter $filter
     * @param int $page
     * @param int $size
     * @param string $sort
     * @param string $direction
     * @return PaginationInterface
     */
    public function all(Filter $filter, int $page, int $size, ?string $sort, ?string $direction): PaginationInterface
    {
//        if (!\in_array($sort, [null, 'p.id', 'p.rating', 'p.price_new'], true)) {
//            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
//        }

        $qb = $this->connection->createQueryBuilder()
            ->select(
                'p.id',
                'p.info_name AS name',
                'p.rating',
                'p.price_new AS price',
                'i.info_path',
                'i.info_name'
            )
            ->from('products_products', 'p')
            ->leftJoin(
            'p',
            'images',
            'i',
            'i.id = ( SELECT image_id FROM products_products_images AS pi WHERE pi.product_id = p.id ORDER BY `image_id` DESC LIMIT 1)');


        //dd($qb->fetchAllAssociative());


        $pagination = $this->paginator->paginate($qb, $page, $size);


        return $pagination;
    }
}
