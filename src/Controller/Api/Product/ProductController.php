<?php

namespace App\Controller\Api\Product;

use App\Controller\Api\PaginationSerializer;
use App\ReadModel\Product\Product\ProductFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private const PER_PAGE = 6;

    #[Route('/api/products', name: 'api-products')]
    public function index(Request $request, ProductFetcher $fetcher, $app_url): Response
    {
        $pagination = $fetcher->all(
            json_decode($request->query->get('filter'), true),
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort'),
            $request->query->get('direction'),
            $request->query->get('category')
        );

        return $this->json([
            'items' => array_map(static function (array $item) use($app_url) {
                $image_src = $app_url . '/images/default.png';
                if ($item['info_path'] && $item['info_name']) {
                    $image_src = $app_url . '/uploads/' . $item['info_path'] . '/' . $item['info_name'];
                }

                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'rating' => $item['rating'],
                    'slug' => $item['slug'],
                    'price' => $item['price_new'],
                    'image_src' => $image_src
                ];
            }, (array)$pagination->getItems()),
            'pagination' => PaginationSerializer::toArray($pagination),
        ]);
    }
}
