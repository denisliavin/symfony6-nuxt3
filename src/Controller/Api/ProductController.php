<?php

namespace App\Controller\Api;

use App\ReadModel\Product\ProductFetcher;
use App\ReadModel\Product\Filter\Filter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ProductController extends AbstractController
{
    private const PER_PAGE = 20;

    public function __construct(private DenormalizerInterface $denormalizer)
    {
    }

    #[Route('/api/products', name: 'api-products')]
    public function index(Request $request, ProductFetcher $fetcher, $app_url): Response
    {
        $filter = new Filter();

        /** @var Filter $filter */
        $filter = $this->denormalizer->denormalize($request->query->get('filter'), Filter::class, 'array', [
            'object_to_populate' => $filter
        ]);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort'),
            $request->query->get('direction')
        );

        return $this->json([
            'items' => array_map(static function (array $item) use($app_url) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'rating' => $item['rating'],
                    'price' => $item['price'],
                    'image_src' => $app_url . '/uploads/' . $item['info_path'] . '/' . $item['info_name'],
                ];
            }, (array)$pagination->getItems()),
            'pagination' => PaginationSerializer::toArray($pagination),
        ]);
    }
}
