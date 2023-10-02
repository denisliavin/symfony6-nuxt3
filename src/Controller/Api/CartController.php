<?php

namespace App\Controller\Api;

use App\ReadModel\Product\Cart\CartFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Model\Cart\UseCase\Cart;

class CartController extends AbstractController
{
    private $serializer;
    private $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    #[Route('/api/cart/add', methods: ['POST'])]
    public function add(Request $request, Cart\Items\Add\ByClient\Handler $handler): Response
    {
        $data = json_decode($request->getContent(), true);
        $command = new Cart\Items\Add\ByClient\Command(
            isset($data['product_id']) ? $data['product_id'] : '',
            isset($data['featuresValues_ids']) ? $data['featuresValues_ids'] : [],
            isset($data['key']) ? $data['key'] : ''
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, 400, [], true);
        }

        $handler->handle($command);

        return $this->json([]);
    }

    #[Route('/api/cart/set', methods: ['POST'])]
    public function set(Request $request, Cart\Items\Set\ByClient\Handler $handler): Response
    {
        $data = json_decode($request->getContent(), true);
        $command = new Cart\Items\Set\ByClient\Command(
            isset($data['item_id']) ? $data['item_id'] : '',
            isset($data['quantity']) ? $data['quantity'] : 0,
            isset($data['key']) ? $data['key'] : ''
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, 400, [], true);
        }

        $handler->handle($command);

        return $this->json([]);
    }

    #[Route('/api/cart/remove', methods: ['POST'])]
    public function remove(Request $request, Cart\Items\Remove\ByClient\Handler $handler): Response
    {
        $data = json_decode($request->getContent(), true);
        $command = new Cart\Items\Remove\ByClient\Command(
            isset($data['item_id']) ? $data['item_id'] : '',
            isset($data['key']) ? $data['key'] : ''
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, 400, [], true);
        }

        $handler->handle($command);

        return $this->json([]);
    }

    #[Route('/api/cart/count', methods: ['GET'])]
    public function count(Request $request, CartFetcher $fetcher): Response
    {
        $count = $fetcher->findCountItems(null, $request->query->get('key'));

        return $this->json($count);
    }

    #[Route('/api/cart/items', methods: ['GET'])]
    public function items(Request $request, CartFetcher $fetcher, $app_url): Response
    {
        $cartItems = $fetcher->findItems(null, $request->query->get('key'));

        return $this->json(array_map(static function (array $item) use($app_url) {
            $image_src = $app_url . '/images/default.png';
            if ($item['info_path'] && $item['info_name']) {
                $image_src = $app_url . '/uploads/' . $item['info_path'] . '/' . $item['info_name'];
            }

            return [
                'id' => $item['id_value'],
                'quantity' => $item['quantity'],
                'name' => $item['product_name'],
                'slug' => $item['slug'],
                'price' => $item['price_new'],
                'image_src' => $image_src
            ];
        }, (array)$cartItems));
    }

    #[Route('/api/cart/info', methods: ['GET'])]
    public function info(Request $request, CartFetcher $fetcher, $app_url): Response
    {
        $cartItems = $fetcher->existsCoupon(null, $request->query->get('key'));

        return $this->json($cartItems);
    }
}
