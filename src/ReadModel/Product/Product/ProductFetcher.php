<?php

declare(strict_types=1);

namespace App\ReadModel\Product\Product;

use App\Model\Product\Entity\Product\Product;
use App\ReadModel\Product\Product\Filter\Filter;
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
     * @param array $filter
     * @param int $page
     * @param int $size
     * @param string $sort
     * @param string $direction
     * @return PaginationInterface
     */
    public function all(
        $filter,
        int $page,
        int $size,
        ?string $sort,
        ?string $direction,
        ?string $category
    ): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'p.id_value',
                'p.info_name AS name',
                'p.rating',
                'p.slug',
                'p.price_new',
                'i.info_path',
                'i.info_name'
            )
            ->from('products_products', 'p')
            ->leftJoin(
            'p',
            'images',
            'i',
            'i.id_value = ( SELECT image_id FROM products_products_images AS pi WHERE pi.product_id = p.id_value ORDER BY `image_id` DESC LIMIT 1)');

        if ($category) {
            $qb->innerJoin('p', 'products_categories', 'pc', 'p.category_id = pc.id_value');
            $qb->andWhere('pc.slug = :slug');
            $qb->setParameter('slug', $category);
        }

        if (isset($filter['brand']) && $filter['brand']) {
            $qb->innerJoin('p', 'products_brands', 'pb', 'p.brand_id = pb.id_value');
            $qb->andWhere('pb.id_value = :slug_id');
            $qb->setParameter('slug_id', $filter['brand']);
        }

        if (isset($filter['tag']) && $filter['tag']) {
            $qb->innerJoin('p', 'products_tags', 'pt', 'p.tag_id = pt.id_value');
            $qb->andWhere('pt.id_value = :tag_id');
            $qb->setParameter('tag_id', $filter['tag']);
        }

        if (isset($filter['q']) && $filter['q']) {
            $qb->andWhere('(LOWER(p.info_name) LIKE :q OR LOWER(p.info_description) LIKE :q OR LOWER(p.info_specification) LIKE :q)');
            $qb->setParameter('q', '%' . mb_strtolower($filter['q']) . '%');
        }

        if ($filter['price_from'] && is_numeric($filter['price_from'])) {
            $qb->andWhere('p.price_new >= :price_new');
            $qb->setParameter('price_new', $filter['price_from']);
        }

        if ($filter['price_to'] && is_numeric($filter['price_to'])) {
            $qb->andWhere('p.price_new <= :price_to');
            $qb->setParameter('price_to', $filter['price_to']);
        }

        if (in_array($sort, ['id', 'rating', 'price_new']) && in_array($direction, [null, 'asc', 'desc'])) {
            $qb->orderBy('p.' . $sort, $direction);
        }

        $pagination = $this->paginator->paginate($qb, $page, $size);


        return $pagination;
    }
}
