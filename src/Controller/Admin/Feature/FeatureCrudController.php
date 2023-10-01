<?php

namespace App\Controller\Admin\Feature;

use App\Model\Feature\Entity\Feature\Feature;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\Feature\UseCase as UseCase;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class FeatureCrudController extends \App\Controller\Admin\AbstractCrudController
{
    public $createHandler;
    public $editHandler;
    public $removeHandler;

    public function __construct(
        UseCase\Feature\Create\Handler $createHandler,
        UseCase\Feature\Edit\Handler $editHandler,
        UseCase\Feature\Remove\Handler $removeHandler,
    )
    {
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
            AssociationField::new('values')
                ->autocomplete()->setCrudController(FeatureValueCrudController::class)->setDisabled()->onlyWhenUpdating()
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        if (isset($_GET['entityId'])) {
            $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(FeatureValueCrudController::class)
                ->setAction(Action::INDEX)
                ->set('feature_id', $_GET['entityId'])
                ->generateUrl();

            $toValues = Action::new('ToValues', 'To values', 'fa fa-file-invoice')
                ->linkToUrl($url);

            $actions->add(Crud::PAGE_EDIT, $toValues);
        }

        return $actions;
    }
}
