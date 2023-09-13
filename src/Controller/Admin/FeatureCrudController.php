<?php

namespace App\Controller\Admin;

use App\Model\Feature\UseCase as UseCase;
use App\Model\Feature\Entity\Feature\Feature;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FeatureCrudController extends AbstractCrudController
{
    public $entityManager;
    public $createHandler;
    public $editHandler;
    public $removeHandler;

    public function __construct(
        EntityManagerInterface $entityManager,
        UseCase\Feature\Create\Handler $createHandler,
        UseCase\Feature\Edit\Handler $editHandler,
        UseCase\Feature\Remove\Handler $removeHandler,
    )
    {
        $this->entityManager = $entityManager;
        $this->createHandler = $createHandler;
        $this->editHandler = $editHandler;
        $this->removeHandler = $removeHandler;
    }

    public static function getEntityFqcn(): string
    {
        return Feature::class;
    }

    public function getNewCommand()
    {
        return new UseCase\Feature\Create\Command();
    }

    public function getEditCommand($id)
    {
        return new UseCase\Feature\Edit\Command($id);
    }

    public function getRemoveCommand($id)
    {
        return new UseCase\Feature\Remove\Command($id);
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
            TextareaField::new('description'),
            AssociationField::new('values')->autocomplete()->setDisabled()->onlyWhenUpdating()
        ];
    }
}
