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
        $tags = $fetcher->all();

        return $this->json(array_map(static function (array $item) {
            return [
                'id' => $item['id_value'],
                'name' => $item['name'],
                'slug' => $item['slug'],
            ];
        }, (array)$tags));
    }
}
