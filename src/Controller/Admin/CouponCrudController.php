<?php

namespace App\Controller\Admin;

use App\Model\Coupon\UseCase as UseCase;
use App\Model\Coupon\Entity\Coupon\Coupon;
use Doctrine\ORM\EntityManagerInterface;

class CouponCrudController extends AbstractCrudController
{
    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Coupon::class;
    }

    public function getNewCommand()
    {
        return new UseCase\Coupon\Create\Command(null);
    }

    public function getEditCommand($id)
    {
        return new UseCase\Coupon\Update\Command($id);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        //dd($entityInstance);
//        $entityManager->persist($entityInstance);
//        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        //dd($entityInstance);
//        $entityManager->persist($entityInstance);
//        $entityManager->flush();
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
