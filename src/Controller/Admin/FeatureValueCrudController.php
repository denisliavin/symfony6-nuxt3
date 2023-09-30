<?php

namespace App\Controller\Admin;

use App\Model\Feature\Entity\Feature\FeatureRepository;
use App\Model\Feature\Entity\FeatureValue\FeatureValue;
use App\Model\Feature\UseCase as UseCase;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FeatureValueCrudController extends AbstractCrudController
{
    public $attachValueHandler;
    public $editValueHandler;
    public $detachValueHandler;
    public $features;

    public function __construct(
        UseCase\Feature\Value\Attach\Handler $attachValueHandler,
        UseCase\Feature\Value\Edit\Handler $editValueHandler,
        UseCase\Feature\Value\Detach\Handler $detachValueHandler,
        FeatureRepository $features
    )
    {
        $this->features = $features;
        $this->attachValueHandler = $attachValueHandler;
        $this->editValueHandler = $editValueHandler;
        $this->detachValueHandler = $detachValueHandler;
    }

    public static function getEntityFqcn(): string
    {
        return FeatureValue::class;
    }

    public function getNewCommand()
    {
        return new UseCase\Feature\Value\Attach\Command();
    }

    public function getEditCommand($id)
    {
        return new UseCase\Feature\Value\Edit\Command($id);
    }

    public function getRemoveCommand($id)
    {
        return new UseCase\Feature\Value\Detach\Command($id);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->attachValueHandler->handle($command);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->editValueHandler->handle($command);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->detachValueHandler->handle($command);
    }

    public function configureFields(string $pageName): iterable
    {
        $features = $this->features->findAll();

        return [
            IdField::new('id.value')->onlyOnIndex(),
            TextField::new('name'),
            HiddenField::new('feature_id')->onlyWhenUpdating(),
            ChoiceField::new('feature_id', 'Feature ')->setChoices(array_reduce(
                $features,
                function($carry, $item) {
                    return [$item->getName() => $item->getId()->getValue()];
                }
            ))->hideWhenUpdating()
        ];
    }
}
