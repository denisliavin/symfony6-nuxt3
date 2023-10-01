<?php

namespace App\Controller\Api\Product;

use App\ReadModel\Product\Brand\BrandFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandController extends AbstractController
{
    #[Route('/api/brands', name: 'api-brands')]
    public function index(BrandFetcher $fetcher): Response
    {
        $brands = $fetcher->all();

        return $this->json(array_map(static function (array $item) {
            return [
                'id' => $item['id_value'],
                'name' => $item['name'],
                'slug' => $item['slug'],
                'products' => $item['products']
            ];
        }, (array)$brands));
    }
}
