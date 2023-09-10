<?php

namespace App\Controller\Admin;

use App\Model\Coupon\Entity\Coupon;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FormFactory;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

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

    public function createEditForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface
    {
        if ($_POST) {
            $command = new \App\Controller\Admin\CouponCommand($entityDto->getInstance()->getId());
            $entityDto->setInstance(null);
            $entityDto->setInstance($command);
            $context->getEntity()->setInstance(null);
            $context->getEntity()->setInstance($command);
        }

        return $this->createEditFormBuilder($entityDto, $formOptions, $context)->getForm();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        //dd($_POST);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

//
//    public function createEditForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface
//    {
//        //return $this->createEditFormBuilder($entityDto, $formOptions, $context)->getForm();
//        $coupon = $this->entityManager->getRepository(Coupon::class)->find(32);
//        return $this->createForm(CouponForm::class, new Coupon());
//    }

//    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
//    {
//        return $this->createFormBuilder(CouponForm::class, new CouponCommand());
//        //return $this->createForm(CouponForm::class, new CouponCommand());
//        dd($this->container->get(FormFactory::class)->createNewFormBuilder($entityDto, $formOptions, $context));
//        return $this->container->get(FormFactory::class)->createNewFormBuilder($entityDto, $formOptions, $context);
//    }
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
