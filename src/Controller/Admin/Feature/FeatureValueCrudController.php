<?php

namespace App\Controller\Admin\Feature;

use App\Controller\Admin\User\Cart\CartCrudController;
use App\Controller\Admin\User\Cart\CartItemCrudController;
use App\Model\Feature\Entity\Feature\FeatureRepository;
use App\Model\Feature\Entity\FeatureValue\FeatureValue;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\Feature\UseCase as UseCase;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class FeatureValueCrudController extends \App\Controller\Admin\AbstractCrudController
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

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $query = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if (isset($_GET['feature_id'])) {
            $query->andWhere('entity.feature = :id')
                ->setParameter(':id', $_GET['feature_id']);
        }

        return $query;
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
            HiddenField::new('feature_id')->onlyWhenUpdating(),
            TextField::new('name')
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        if (isset($_GET['feature_id'])) {
            $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(FeatureCrudController::class)
                ->setAction(Action::EDIT)
                ->setEntityId($_GET['feature_id'])
                ->generateUrl();

            $toFeature = Action::new('ToFeature', 'To feature', 'fa fa-file-invoice')
                ->linkToUrl($url)->createAsGlobalAction();

            $actions->add(Crud::PAGE_INDEX, $toFeature);

            $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(FeatureValueCrudController::class)
                ->setAction(Action::NEW)
                ->set('feature_id', $_GET['feature_id'])
                ->generateUrl();

            $actions->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) use ($url) {
                return $action->linkToUrl($url);
            });
        }

        return $actions;
    }
}
