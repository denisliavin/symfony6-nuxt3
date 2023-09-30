<?php

namespace App\Controller\Admin;

use App\Model\Coupon\Entity\Coupon\Sale;
use App\Model\Coupon\UseCase as UseCase;
use App\Model\Coupon\Entity\Coupon\Coupon;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CouponCrudController extends AbstractCrudController
{
    public $entityManager;
    public $createHandler;
    public $editHandler;
    public $removeHandler;

    public function __construct(
        EntityManagerInterface $entityManager,
        UseCase\Coupon\Create\Handler $createHandler,
        UseCase\Coupon\Edit\Handler $editHandler,
        UseCase\Coupon\Remove\Handler $removeHandler,
    )
    {
        $this->entityManager = $entityManager;
        $this->createHandler = $createHandler;
        $this->editHandler = $editHandler;
        $this->removeHandler = $removeHandler;
    }

    public static function getEntityFqcn(): string
    {
        return Coupon::class;
    }

    public function getNewCommand()
    {
        return new UseCase\Coupon\Create\Command();
    }

    public function getEditCommand($id)
    {
        return new UseCase\Coupon\Edit\Command($id);
    }

    public function getRemoveCommand($id)
    {
        return new UseCase\Coupon\Remove\Command($id);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->createHandler->handle($command);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->editHandler->handle($command);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->removeHandler->handle($command);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('code'),
            ChoiceField::new('sale.type', 'Type')->setChoices([
                'Number' => Sale::NUM,
                'Percent' => Sale::PERCENT
            ]),
            TextField::new('sale.value', 'Value')
        ];
    }
}
