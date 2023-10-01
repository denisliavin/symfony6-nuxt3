<?php

namespace App\Controller\Api;

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

        return $this->json([
            'name' => 'add',
        ]);
    }
}
