<?php

namespace App\Controller\Api;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/api/profile', name: 'api-profile')]
    public function index(): Response
    {
        return $this->json([
            'name' => 'JSON API',
        ]);
    }
}
