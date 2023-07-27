<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeContrillerController extends AbstractController
{
    #[Route('/', name: 'app_welcome_contriller')]
    public function index(): Response
    {
        return $this->render('welcome_contriller/index.html.twig', [
            'controller_name' => 'WelcomeContrillerController',
        ]);
    }
}
