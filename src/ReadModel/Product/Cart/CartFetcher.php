<?php

declare(strict_types=1);

namespace App\ReadModel\Product\Cart;

use Doctrine\DBAL\Connection;

class CartFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findCountItems($user_id, $guests_key)
    {
        if (!$user_id && !$guests_key) {
            return null;
        }

        $qb = $this->connection->createQueryBuilder()
            ->select(
                'cci.id_value'
            )
            ->from('carts_carts_items', 'cci')
            ->innerJoin('cci', 'carts_carts', 'cc', 'cci.cart_id = cc.id_value')
            ->innerJoin('cc', 'carts_carts_owners', 'cco', 'cc.owner_id = cco.id_value');

        if ($user_id) {
            $qb->andWhere('cco.user_id = :user_id')->setParameter('user_id', $user_id);
        }

        if ($guests_key) {
            $qb->andWhere('cco.guests_key = :guests_key')->setParameter('guests_key', $guests_key);
        }

        return $qb->executeQuery()->rowCount();
    }

    public function findItems($user_id, $guests_key)
    {
        if (!$user_id && !$guests_key) {
            return null;
        }

        $qb = $this->connection->createQueryBuilder()
            ->select(
                'cci.id_value',
                'cci.quantity',
                'pp.info_name AS product_name',
                'pp.price_new',
                'pp.slug',
                'i.info_path',
                'i.info_name'
            )
            ->from('carts_carts_items', 'cci')
            ->innerJoin('cci', 'products_products', 'pp', 'cci.product_id = pp.id_value')
            ->leftJoin(
                'pp',
                'images',
                'i',
                'i.id_value = ( SELECT image_id FROM products_products_images AS pi WHERE pi.product_id = pp.id_value ORDER BY `image_id` DESC LIMIT 1)')
            ->innerJoin('cci', 'carts_carts', 'cc', 'cci.cart_id = cc.id_value')
            ->innerJoin('cc', 'carts_carts_owners', 'cco', 'cc.owner_id = cco.id_value');

        if ($user_id) {
            $qb->andWhere('cco.user_id = :user_id')->setParameter('user_id', $user_id);
        }

        if ($guests_key) {
            $qb->andWhere('cco.guests_key = :guests_key')->setParameter('guests_key', $guests_key);
        }

        return $qb->fetchAllAssociative();
    }

    public function existsCoupon($user_id, $guests_key)
    {
        if (!$user_id && !$guests_key) {
            return null;
        }

        $qb = $this->connection->createQueryBuilder()
            ->select(
                'cc.id_value'
            )
            ->from('carts_carts', 'cc')
            ->innerJoin('cc', 'carts_carts_owners', 'cco', 'cc.owner_id = cco.id_value')
            ->innerJoin('cc', 'coupons', 'c', 'cc.coupon_id = cco.id_value');

        if ($user_id) {
            $qb->andWhere('cco.user_id = :user_id')->setParameter('user_id', $user_id);
        }

        if ($guests_key) {
            $qb->andWhere('cco.guests_key = :guests_key')->setParameter('guests_key', $guests_key);
        }

        return $qb->fetchAllAssociative();
    }
}
