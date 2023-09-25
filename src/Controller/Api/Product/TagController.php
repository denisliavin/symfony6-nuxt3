<?php

namespace App\Controller\Api\Product;

use App\ReadModel\Product\Tag\TagFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    #[Route('/api/tags', name: 'api-tags')]
    public function index(TagFetcher $fetcher): Response
    {
        $categories = $fetcher->all();

        return $this->json($categories);
    }
}
