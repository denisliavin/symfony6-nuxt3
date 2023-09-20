<?php

namespace App\Controller\Admin;

use App\Model\Product\UseCase as UseCase;
use App\Model\Product\Entity\Category\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryCrudController extends AbstractCrudController
{
    public $entityManager;
    public $createHandler;
    public $editHandler;
    public $removeHandler;

    public function __construct(
        EntityManagerInterface $entityManager,
        UseCase\Category\Create\Handler $createHandler,
        UseCase\Category\Edit\Handler $editHandler,
        UseCase\Category\Remove\Handler $removeHandler,
    )
    {
        $this->entityManager = $entityManager;
        $this->createHandler = $createHandler;
        $this->editHandler = $editHandler;
        $this->removeHandler = $removeHandler;
    }

    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function getNewCommand()
    {
        return new UseCase\Category\Create\Command();
    }

    public function getEditCommand($id)
    {
        return new UseCase\Category\Edit\Command($id);
    }

    public function getRemoveCommand($id)
    {
        return new UseCase\Category\Remove\Command($id);
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
