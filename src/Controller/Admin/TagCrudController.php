<?php

namespace App\Controller\Admin;

use App\Model\Product\UseCase as UseCase;
use App\Model\Product\Entity\Tag\Tag;
use Doctrine\ORM\EntityManagerInterface;

class TagCrudController extends AbstractCrudController
{
    public $createHandler;
    public $editHandler;
    public $removeHandler;

    public function __construct(
        UseCase\Tag\Create\Handler $createHandler,
        UseCase\Tag\Edit\Handler $editHandler,
        UseCase\Tag\Remove\Handler $removeHandler,
    )
    {
        $this->createHandler = $createHandler;
        $this->editHandler = $editHandler;
        $this->removeHandler = $removeHandler;
    }

    public static function getEntityFqcn(): string
    {
        return Tag::class;
    }

    public function getNewCommand()
    {
        return new UseCase\Tag\Create\Command();
    }

    public function getEditCommand($id)
    {
        return new UseCase\Tag\Edit\Command($id);
    }

    public function getRemoveCommand($id)
    {
        return new UseCase\Tag\Remove\Command($id);
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
