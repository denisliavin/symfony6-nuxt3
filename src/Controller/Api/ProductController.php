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
    public function index(Request $request, ProductFetcher $fetcher): Response
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
            'items' => array_map(static function (array $item) {
                return [
                    'id' => $item['id'],
                    'project' => [
                        'id' => $item['project_id'],
                        'name' => $item['project_name'],
                    ],
                    'author' => [
                        'id' => $item['author_id'],
                        'name' => $item['author_name'],
                    ],
                    'date' => $item['date'],
                    'plan_date' => $item['plan_date'],
                    'parent' => $item['parent'],
                    'name' => $item['name'],
                    'type' => $item['type'],
                    'progress' => $item['progress'],
                    'priority' => $item['priority'],
                    'status' => $item['status'],
                    'executors'=> array_map(static function (array $member) {
                        return [
                            'name' => $member['name'],
                        ];
                    }, $item['executors']),
                ];
            }, (array)$pagination->getItems()),
            'pagination' => PaginationSerializer::toArray($pagination),
        ]);
    }
}
