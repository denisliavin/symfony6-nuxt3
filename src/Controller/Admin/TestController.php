<?php

namespace App\Controller\Admin;

use App\Model\Cart\Entity\CartOwner\CartOwner;
use App\Model\Cart\Entity\CartOwner\Id;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/admin/test', name: 'admin_test')]
    public function test(EntityManagerInterface $em)
    {
        $obj = new CartOwner(Id::next(), 'dwqdqw');

        $em->persist($obj);
        $em->flush();
        dd(32);
    }
}
