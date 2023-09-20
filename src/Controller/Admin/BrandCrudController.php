<?php

namespace App\Controller\Admin;

use App\Model\Product\UseCase as UseCase;
use App\Model\Product\Entity\Brand\Brand;
use Doctrine\ORM\EntityManagerInterface;

class BrandCrudController extends AbstractCrudController
{
    public $entityManager;
    public $createHandler;
    public $editHandler;
    public $removeHandler;

    public function __construct(
        EntityManagerInterface $entityManager,
        UseCase\Brand\Create\Handler $createHandler,
        UseCase\Brand\Edit\Handler $editHandler,
        UseCase\Brand\Remove\Handler $removeHandler,
    )
    {
        $this->entityManager = $entityManager;
        $this->createHandler = $createHandler;
        $this->editHandler = $editHandler;
        $this->removeHandler = $removeHandler;
    }

    public static function getEntityFqcn(): string
    {
        return Brand::class;
    }

    public function getNewCommand()
    {
        return new UseCase\Brand\Create\Command();
    }

    public function getEditCommand($id)
    {
        return new UseCase\Brand\Edit\Command($id);
    }

    public function getRemoveCommand($id)
    {
        return new UseCase\Brand\Remove\Command($id);
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
}
