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
        $categories = $fetcher->all();

        return $this->json($categories);
    }
}
