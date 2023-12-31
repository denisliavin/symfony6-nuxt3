<?php

namespace App\Controller\Admin\User\Cart;

use App\Controller\Admin\Product\ProductCrudController;
use App\Model\Cart\UseCase\Cart\Items;
use App\Controller\Admin\AbstractCrudController;
use App\Model\Cart\Entity\CartItem\CartItem;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class CartItemCrudController extends AbstractCrudController
{
    public $setHandler;
    public $createHandler;
    public $removeHandler;

    public function __construct(
        Items\Add\Manual\Handler $createHandler,
        Items\Set\Manual\Handler $setHandler,
        Items\Remove\Manual\Handler $removeHandler
    )
    {
        $this->setHandler = $setHandler;
        $this->createHandler = $createHandler;
        $this->removeHandler = $removeHandler;
    }

    public static function getEntityFqcn(): string
    {
        return CartItem::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $query = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if (isset($_GET['cart_id'])) {
            $query->andWhere('entity.cart = :id')
                ->setParameter(':id', $_GET['cart_id']);
        }

        return $query;
    }

    public function getNewCommand()
    {
        return new Items\Add\Manual\Command();
    }

    public function getEditCommand($id)
    {
        return new Items\Set\Manual\Command($id);
    }

    public function getRemoveCommand($id)
    {
        return new Items\Remove\Manual\Command($id);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->createHandler->handle($command);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->setHandler->handle($command);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->removeHandler->handle($command);
    }

    public function configureActions(Actions $actions): Actions
    {
        if (isset($_GET['cart_id']) && isset($_GET['user_id'])) {
            $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(CartCrudController::class)
                ->setAction(Action::EDIT)
                ->setEntityId($_GET['cart_id'])
                ->set('user_id', $_GET['user_id'])
                ->generateUrl();

            $toCart = Action::new('ToCart', 'To cart', 'fa fa-file-invoice')
                ->linkToUrl($url)->createAsGlobalAction();

            $actions->add(Crud::PAGE_INDEX, $toCart);

            $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(CartItemCrudController::class)
                ->setAction(Action::NEW)
                ->set('cart_id', $_GET['cart_id'])
                ->generateUrl();

            $actions->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) use ($url) {
                return $action->linkToUrl($url);
            });

            $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(CartItemCrudController::class)
                ->setAction(Action::DELETE)
                ->set('cart_id', $_GET['cart_id'])
                ->generateUrl();

            $actions->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) use ($url) {
                return $action->linkToUrl($url);
            });
        }

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_INDEX === $pageName) {
            return [
                IdField::new('id'),
                AssociationField::new('product')->setCrudController(ProductCrudController::class),
                AssociationField::new('featuresValues')->setCrudController(ProductCrudController::class),
                NumberField::new('quantity')
            ];
        } elseif(Crud::PAGE_NEW === $pageName) {
            return [
                NumberField::new('quantity'),
                AssociationField::new('product')->autocomplete(),
                AssociationField::new('featuresValues')->autocomplete()
            ];
        } else {
            return [
                NumberField::new('quantity'),
                HiddenField::new('cart')
            ];
        }
    }
}
