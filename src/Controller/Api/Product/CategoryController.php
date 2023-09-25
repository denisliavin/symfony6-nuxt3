<?php

namespace App\Controller\Api\Product;

use App\ReadModel\Product\Category\CategoryFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/api/categories', name: 'api-categories')]
    public function index(CategoryFetcher $fetcher): Response
    {
        $categories = $fetcher->all();

        return $this->json($categories);
    }
}
